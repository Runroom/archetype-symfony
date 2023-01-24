<?php

declare(strict_types=1);

namespace Deployer;

require 'recipe/composer.php';

set('keep_releases', 3);
set('repository', 'git@github.com:Runroom/archetype-symfony.git');
set('shared_dirs', ['public/uploads']);
set('shared_files', ['.env.local', 'public/robots.txt']);
set('writable_dirs', ['var/log', 'var/cache', 'public/uploads']);
set('clear_paths', ['.docker', '.github', 'assets', 'doc', 'etc', 'tests']);

set('default_timeout', null);
set('allow_anonymous_stats', false);
set('console', 'bin/console');
set('composer_options', '--classmap-authoritative --no-progress --no-interaction --no-dev');

task('app', function (): void {
    cd('{{release_path}}');

    run('{{bin/composer}} symfony:dump-env');
    run('{{bin/php}} {{console}} cache:warmup --no-interaction');
    run('{{bin/php}} {{console}} assets:install public --relative');
})->hidden();

task('migrations', function (): void {
    cd('{{release_path}}');

    run('{{bin/php}} {{console}} doctrine:migrations:migrate --no-interaction --allow-no-migration');
})->select('stage=production');

task('fixtures', function (): void {
    cd('{{release_path}}');

    run('{{bin/php}} {{console}} doctrine:schema:drop --full-database --no-interaction --force');
    run('{{bin/php}} {{console}} doctrine:migrations:migrate --no-interaction --allow-no-migration');
    run('{{bin/php}} {{console}} doctrine:fixtures:load --no-interaction --env=staging');
})->select('stage=staging');

task('frontend:upload', function (): void {
    askConfirmation('Did you generate the frontend assets?');

    upload('public/build/', '{{release_path}}/public');
    upload('public/ckeditor/', '{{release_path}}/public');
})->hidden();

task('restart-workers', function (): void {
    if (has('previous_release')) {
        cd('{{previous_release}}');

        run('{{bin/php}} {{console}} messenger:stop-workers');
    }
})->hidden();

after('deploy:vendors', 'frontend:upload');
after('frontend:upload', 'app');
after('app', 'migrations');
after('app', 'fixtures');
before('deploy:symlink', 'deploy:clear_paths');
after('deploy:symlink', 'restart-workers');
after('deploy:failed', 'deploy:unlock');

import('servers.php');
