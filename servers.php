<?php

declare(strict_types=1);

namespace Deployer;

host('symfony.runroom.dev')
    ->setHostname(getenv('DEPLOYER_HOST'))
    ->setDeployPath('~/symfony.runroom.dev')
    // labelling with "stage" => "staging" will reset database and load doctrine fixtures
    ->setLabels(['stage' => 'staging'])
    ->setRemoteUser(getenv('DEPLOYER_USER'));
