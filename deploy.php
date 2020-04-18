<?php

namespace Deployer;

require 'recipe/composer.php';

set('repository', 'git@github.com:Runroom/archetype-symfony.git');

set('copy_dirs', ['vendor', 'node_modules']);
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

    run('. ~/.nvm/nvm.sh && {{bin/yarn}} && {{bin/yarn}} encore production');
})->setPrivate();

before('deploy:vendors', 'deploy:copy_dirs');
after('deploy:vendors', 'yarn:build');
after('yarn:build', 'app');
after('deploy:failed', 'deploy:unlock');

inventory('servers.yaml')
    ->user(\getenv('DEPLOYER_USER'));
