# Symfony Archetype

## Create new project

In order to create a new project from this archetype clone this repo and run the following command:

    sh init_project.sh

## Setup

Clone repository:

    git clone git@bitbucket.org:runroom/archetype-symfony.git

Install the hostmanager plugin

    vagrant plugin install vagrant-hostmanager

Virtual machine up:

    vagrant up


## Environment

Open `http://symfony.dev` in your browser.

- Run `phpunit` to perform tests.
- Run `phpunit-coverage` to generate coverage.
- Run `php-cs-fixer fix` to fix PHP coding standards
- Run `phpmd` to do an analysis of the code
- Run `ansible-run database,migrations` to restore database and execute migrations

- Run `yarn start` or `yarn gulp` to run gulp default task
- Run `yarn gulp -- <task>` to run any gulp task


## Releases

### Development

To deploy a new release just commit and push changes to development branch:

    git add -A
    git commit -m "<message>"
    git push origin development

### Production

To deploy a new release just merge development to master:

    git checkout master
    git merge development
    git push origin master

Or commit and push changes to master branch directly:

    git add -A
    git commit -m "<message>"
    git push origin master

## Contribute

Please refer to [CONTRIBUTING](doc/Contributing.md) for information on how
to contribute to the Archetype and its related projects.

## Additional documentation

- [Ansible](doc/Ansible.md)
- [Configuration](doc/Configuration.md)
- [Continuous Integration](doc/Continuous_integration.md)
- [Deploy](doc/Deployment.md)
- [Migrations](doc/Migrations.md)
- [New features](doc/New_features.md)
