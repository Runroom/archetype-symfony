<?php

declare(strict_types=1);

namespace Deployer;

host('symfony.runroom.dev')
    ->setDeployPath('~/symfony.runroom.dev')
    // role "staging" will reset database and load doctrine fixtures
    ->set('roles', 'staging')
    ->setRemoteUser(getenv('DEPLOYER_USER'));
