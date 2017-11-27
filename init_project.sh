#!/bin/bash
#
# Start a new Symfony project
#
# Replace the default archetype values with the project name
# and reset the git repository with the user specified remote url
#

TMP_DIR='/tmp'
GREEN='\033[1;32m'
RED='\033[1;31m'
NC='\033[0m'

# Replace text in files using sed and a temporary file
# for OSX/Linux compatibility
function replace {
    sed "s~$1~$2~g" $3 > $TMP_DIR/$3
    mv $TMP_DIR/$3 $3
}

function say_success {
    echo -e "${GREEN}$1${NC}"
}

function say_fail {
    echo -e "${RED}$1${NC}"
}

##############
# USER INPUT #
##############

# Get project name and make sure it's not empty
echo -n "Project name: "
read project_name
if [ "${project_name}" == "" ]
    then
        say_fail "\n¯\_(ツ)_/¯ Project name can't be empty...\n"
        exit 1
fi

# Get the git remote url
# Use a default url in case the user input is empty
remote_url="git@bitbucket.org:runroom/$project_name.git"
echo -n "Remote url [$remote_url]: "
read remote_url_input
if [ ! "$remote_url_input" == "" ]
    then
        remote_url=$remote_url_input
fi

##########################
# REPLACE DEFAULT VALUES #
##########################

# Update composer file
replace "runroom/symfony_archetype" "runroom/$project_name" composer.json

# Update deploy file
replace "git@bitbucket.org:runroom/archetype-symfony.git" $remote_url deploy.php

# Update package file
replace "archetype-symfony" $project_name package.json
replace "Runroom Symfony archetype" $project_name package.json
replace "git@bitbucket.org:runroom/archetype-symfony.git" $remote_url package.json

# Update servers file
replace "192.168.1.219:" "# 127.0.0.1:" servers.yml
replace "    user: runroom" "#     user: username" servers.yml
replace "    stage: development" "#     stage: development" servers.yml
replace "    deploy_path: /home/runroom/archetype" "#     deploy_path: /var/www/$project_name" servers.yml
replace "    branch: development" "#     branch: development" servers.yml

# Update ansible vars
cd ./ansible
replace "servername: symfony.dev" "servername: $project_name.dev" vars.yml
replace "database: symfony" "database: $project_name" vars.yml
cd -

# Update Vagrantfile
replace "symfony" $project_name Vagrantfile

# Update Readme file
replace "# Symfony Archetype" "# $project_name" README.md
replace "git@bitbucket.org:runroom/archetype-symfony.git" $remote_url README.md
replace "symfony" $project_name README.md

awk 'NR < 2 || NR > 7 {print}' < README.md > $TMP_DIR/README.md
mv $TMP_DIR/README.md README.md

####################
# SELF DESTRUCTION #
####################

rm -- "$0"

##################
# GIT REPO SETUP #
##################

rm -rf .git
git init
git remote add origin $remote_url
git add -A
git commit -m "Initial commit"
git push origin master

###########
# SUCCESS #
###########

say_success "\nヽ(^o^)ノ Let's build something awesome!\n"
exit 0
