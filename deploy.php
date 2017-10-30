<?php

namespace Deployer;

require 'recipe/composer.php';

set('repository', 'git@bitbucket.org:runroom/archetype-symfony.git');
set('shared_dirs', ['var/spool', 'web/uploads']);
set('shared_files', ['app/config/parameters.yml', 'web/robots.txt']); // 'web/.htaccess'
set('writable_dirs', ['var/logs', 'var/cache', 'var/spool', 'web/uploads']);
set('clear_paths', ['web/app_dev.php']);

set('allow_anonymous_stats', false);
set('env', ['SYMFONY_ENV' => 'prod']);
set('console', '{{release_path}}/bin/console');
set('composer_options', '{{composer_action}} --no-dev --prefer-dist --no-progress --no-interaction --classmap-authoritative');

task('app', function () {
    run('{{bin/php}} {{console}} cache:warmup --no-interaction');
    run('{{bin/php}} {{console}} doctrine:migrations:migrate --no-interaction');
})->setPrivate();

after('deploy:update_code', 'deploy:clear_paths');
after('deploy:vendors', 'deploy:writable');
after('deploy:writable', 'app');
after('deploy:failed', 'deploy:unlock');

inventory('servers.yml');
