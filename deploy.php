<?php

namespace Deployer;

require 'recipe/composer.php';

set('repository', 'git@github.com:Runroom/archetype-symfony.git');

set('keep_releases', 3);
set('copy_dirs', ['vendor', 'node_modules']);
set('shared_dirs', ['public/uploads']);
set('shared_files', ['.env.local', 'public/robots.txt']);
set('writable_dirs', ['var/log', 'var/cache', 'public/uploads']);
set('clear_paths', ['assets', 'doc', 'docker', 'node_modules', 'tests']);

set('default_timeout', null);
set('allow_anonymous_stats', false);
set('console', 'bin/console');
set('composer_options', '{{composer_action}} --prefer-dist --classmap-authoritative --no-progress --no-interaction --no-dev');

set('bin/yarn', function () {
    return run('which yarn');
});

task('app', function () {
    cd('{{release_path}}');

    run('{{bin/php}} {{bin/composer}} symfony:dump-env prod');
    run('{{bin/php}} {{console}} cache:warmup --no-interaction');
    run('{{bin/php}} {{console}} doctrine:migrations:migrate --no-interaction');
})->setPrivate();

task('yarn:build', function () {
    cd('{{release_path}}');

    run('. ~/.nvm/nvm.sh && {{bin/yarn}} install --frozen-lockfile && {{bin/yarn}} encore production');
})->setPrivate();

task('restart-workers', function () {
    cd('{{previous_release}}');

    run('{{bin/php}} {{console}} messenger:stop-workers');
})->setPrivate();

before('deploy:vendors', 'deploy:copy_dirs');
after('deploy:vendors', 'yarn:build');
after('yarn:build', 'app');
before('deploy:publish', 'deploy:clear_paths');
after('deploy:symlink', 'restart-workers');
after('deploy:failed', 'deploy:unlock');

inventory('servers.yaml')
    ->user(\getenv('DEPLOYER_USER'));
