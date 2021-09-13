<?php

declare(strict_types=1);

use Runroom\UserBundle\Admin\UserAdmin;
use Runroom\UserBundle\Entity\User;
use Runroom\UserBundle\Twig\GlobalVariables;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Loader\Configurator\ReferenceConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    // Use "service" function for creating references to services when dropping support for Symfony 4
    $services = $containerConfigurator->services();

    $services->set('runroom_user.admin.user', UserAdmin::class)
        ->public()
        ->args([null, User::class, null])
        ->tag('sonata.admin', ['manager_type' => 'orm', 'label' => 'User']);

    $services->set('runroom_user.twig.global_variables', GlobalVariables::class)
        ->arg('$pool', new ReferenceConfigurator('sonata.admin.pool'));
};
