<?php

declare(strict_types=1);

namespace Deployer;

require 'recipe/composer.php';

set('keep_releases', 3);
set('repository', 'git@github.com:Runroom/archetype-symfony.git');
set('shared_dirs', ['public/uploads']);
set('shared_files', ['.env.local', 'public/robots.txt']);
set('writable_dirs', ['var/log', 'var/cache', 'public/uploads']);
set('clear_paths', ['assets', 'doc', 'docker', 'node_modules', 'tests']);

set('default_timeout', null);
set('allow_anonymous_stats', false);
set('console', 'bin/console');
set('composer_options', '{{composer_action}} --classmap-authoritative --no-progress --no-interaction --no-dev');

set('bin/npm', function () {
    return run('. ~/.nvm/nvm.sh && nvm use > /dev/null 2>&1 && which npm');
});

set('bin/npx', function () {
    return run('. ~/.nvm/nvm.sh && nvm use > /dev/null 2>&1 && which npx');
});

task('app', function (): void {
    cd('{{release_path}}');

    run('{{bin/php}} {{bin/composer}} symfony:dump-env');
    run('{{bin/php}} {{console}} cache:warmup --no-interaction');
    run('{{bin/php}} {{console}} assets:install public --relative');
})->setPrivate();

task('migrations', function (): void {
    cd('{{release_path}}');

    run('{{bin/php}} {{console}} doctrine:migrations:migrate --no-interaction --allow-no-migration');
})->onRoles('production');

task('fixtures', function (): void {
    cd('{{release_path}}');

    run('{{bin/php}} {{console}} doctrine:schema:drop --full-database --no-interaction --force');
    run('{{bin/php}} {{console}} doctrine:migrations:migrate --no-interaction --allow-no-migration');
    run('{{bin/php}} {{console}} doctrine:fixtures:load --no-interaction --env=staging');
})->onRoles('staging');

task('frontend:build', function (): void {
    cd('{{release_path}}');

    run('{{bin/npm}} clean-install');
    run('{{bin/npx}} encore production');
})->setPrivate();

task('restart-workers', function (): void {
    if (has('previous_release')) {
        cd('{{previous_release}}');

        run('{{bin/php}} {{console}} messenger:stop-workers');
    }
})->setPrivate();

after('deploy:vendors', 'frontend:build');
after('frontend:build', 'app');
after('app', 'migrations');
after('app', 'fixtures');
before('deploy:symlink', 'deploy:clear_paths');
after('deploy:symlink', 'restart-workers');
after('deploy:failed', 'deploy:unlock');

inventory('servers.yaml')
    ->user(getenv('DEPLOYER_USER'));
