<?php

namespace Deployer;

require 'recipe/composer.php';

set('repository', 'git@github.com:Runroom/archetype-symfony.git');
set('shared_dirs', ['var/spool', 'public/uploads']);
set('shared_files', ['.env.local', 'public/robots.txt']);
set('writable_dirs', ['var/log', 'var/cache', 'var/spool', 'public/uploads']);

set('default_timeout', null);
set('allow_anonymous_stats', false);
set('console', '{{release_path}}/bin/console');
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

    if (has('previous_release')) {
        run('cp -R {{previous_release}}/node_modules {{release_path}}/node_modules');
    }

    run('. ~/.nvm/nvm.sh --no-use && nvm use && {{bin/yarn}} && {{bin/yarn}} encore production');
})->setPrivate();

after('deploy:vendors', 'yarn:build');
after('yarn:build', 'app');
after('deploy:failed', 'deploy:unlock');

inventory('servers.yaml')
    ->user(\getenv('DEPLOYER_USER'));
