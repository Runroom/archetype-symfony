<?php

namespace Deployer;

require 'recipe/composer.php';

set('repository', 'git@bitbucket.org:runroom/archetype-symfony.git');
set('shared_dirs', ['var/logs', 'web/uploads']);
set('shared_files', ['app/config/parameters.yml', 'web/.htaccess', 'web/robots.txt']);
set('writable_dirs', ['var/logs', 'var/cache', 'web/uploads']);
set('clear_paths', ['web/app_dev.php']);

set('ssh_type', 'native');
set('env', 'prod');
set('env_vars', 'SYMFONY_ENV={{env}}');
set('console', '{{release_path}}/bin/console');

task('symfony', function () {
    run('{{bin/php}} {{console}} cache:warmup --env={{env}} --no-debug');
    run('{{bin/php}} {{console}} doctrine:migrations:migrate --env={{env}} --no-interaction');
})->setPrivate();

after('deploy:update_code', 'deploy:clear_paths');
after('deploy:vendors', 'deploy:writable');
after('deploy:writable', 'symfony');

serverList('servers.yml');
