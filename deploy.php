<?php

namespace Deployer;

require 'recipe/composer.php';

set('repository', 'git@bitbucket.org:runroom/archetype-symfony.git');
set('shared_dirs', ['app/logs', 'web/uploads']);
set('shared_files', ['app/config/parameters.yml', 'web/.htaccess', 'web/robots.txt']);
set('writable_dirs', ['app/logs', 'app/cache', 'web/uploads']);
set('writable_use_sudo', false);
set('keep_releases', 5);

set('ssh_type', 'native');
set('env', 'prod');
set('env_vars', 'SYMFONY_ENV={{env}}');
set('console', '{{release_path}}/app/console');

task('symfony', function () {
    run('{{bin/php}} {{console}} cache:warmup --env={{env}} --no-debug');
    run('{{bin/php}} {{console}} doctrine:migrations:migrate --env={{env}} --no-interaction');
})->setPrivate();

after('deploy:vendors', 'deploy:writable');
after('deploy:writable', 'symfony');

serverList('servers.yml');
