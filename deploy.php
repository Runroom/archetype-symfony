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
set('composer_options', '{{composer_action}} --prefer-dist --classmap-authoritative --no-progress --no-interaction --no-dev');

set('bin/yarn', function () {
    return locateBinaryPath('yarn');
});

task('app', function (): void {
    cd('{{release_path}}');

    run('{{bin/php}} {{bin/composer}} symfony:dump-env prod');
    run('{{bin/php}} {{console}} cache:warmup --no-interaction');
    run('{{bin/php}} {{console}} assets:install public --relative');
    run('{{bin/php}} {{console}} doctrine:migrations:migrate --no-interaction --allow-no-migration');
})->setPrivate();

task('yarn:build', function (): void {
    cd('{{release_path}}');

    run('. ~/.nvm/nvm.sh && {{bin/yarn}} install --immutable && {{bin/yarn}} encore production');
})->setPrivate();

task('restart-workers', function (): void {
    cd('{{previous_release}}');

    run('{{bin/php}} {{console}} messenger:stop-workers');
})->setPrivate();

after('deploy:vendors', 'yarn:build');
after('yarn:build', 'app');
before('deploy:symlink', 'deploy:clear_paths');
after('deploy:symlink', 'restart-workers');
after('deploy:failed', 'deploy:unlock');

inventory('servers.yaml')
    ->user(getenv('DEPLOYER_USER'));
