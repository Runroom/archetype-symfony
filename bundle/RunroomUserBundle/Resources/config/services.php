<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Runroom\UserBundle\Controller\SecurityController;
use Runroom\UserBundle\Form\RolesMatrixType;
use Runroom\UserBundle\Repository\UserRepository;
use Runroom\UserBundle\Security\RolesBuilder\AdminRolesBuilder;
use Runroom\UserBundle\Security\RolesBuilder\MatrixRolesBuilder;
use Runroom\UserBundle\Security\RolesBuilder\SecurityRolesBuilder;
use Runroom\UserBundle\Security\UserAuthenticator;
use Runroom\UserBundle\Twig\RolesMatrixExtension;
use Runroom\UserBundle\Twig\RolesMatrixRuntime;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Loader\Configurator\ReferenceConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    // Use "service" function for creating references to services when dropping support for Symfony 4
    // Use "param" function for creating references to parameters when dropping support for Symfony 5.1
    $services = $containerConfigurator->services();

    $services->set('runroom_user.controller.security', SecurityController::class)
        ->public()
        ->arg('$authenticationUtils', new ReferenceConfigurator('security.authentication_utils'))
        ->tag('container.service_subscriber')
        ->call('setContainer', [new ReferenceConfigurator(ContainerInterface::class)]);

    $services->set('runroom_user.form.type.roles_matrix', RolesMatrixType::class)
        ->arg('$rolesBuilder', new ReferenceConfigurator('runroom_user.security.roles_builder.matrix'))
        ->tag('form.type');

    $services->set(UserRepository::class)
        ->arg('$registry', new ReferenceConfigurator('doctrine'))
        ->tag('doctrine.repository_service');

    $services->set('runroom_user.security.user_authenticator', UserAuthenticator::class)
        ->arg('$urlGenerator', new ReferenceConfigurator('router'));

    $services->set('runroom_user.security.roles_builder.admin', AdminRolesBuilder::class)
        ->arg('$authorizationChecker', new ReferenceConfigurator('security.authorization_checker'))
        ->arg('$pool', new ReferenceConfigurator('sonata.admin.pool'))
        ->arg('$configuration', new ReferenceConfigurator('sonata.admin.configuration'))
        ->arg('$translator', new ReferenceConfigurator('translator'));

    $services->set('runroom_user.security.roles_builder.matrix', MatrixRolesBuilder::class)
        ->arg('$tokenStorage', new ReferenceConfigurator('security.token_storage'))
        ->arg('$adminRolesBuilder', new ReferenceConfigurator('runroom_user.security.roles_builder.admin'))
        ->arg('$securityRolesBuilder', new ReferenceConfigurator('runroom_user.security.roles_builder.security'));

    $services->set('runroom_user.security.roles_builder.security', SecurityRolesBuilder::class)
        ->arg('$authorizationChecker', new ReferenceConfigurator('security.authorization_checker'))
        ->arg('$configuration', new ReferenceConfigurator('sonata.admin.configuration'))
        ->arg('$translator', new ReferenceConfigurator('translator'))
        ->arg('$rolesHierarchy', '%security.role_hierarchy.roles%');

    $services->set('runroom_user.twig.extension.roles_matrix', RolesMatrixExtension::class)
        ->tag('twig.extension');

    $services->set('runroom_user.twig.runtime.roles_matrix', RolesMatrixRuntime::class)
        ->arg('$twig', new ReferenceConfigurator('twig'))
        ->arg('$rolesBuilder', new ReferenceConfigurator('runroom_user.security.roles_builder.matrix'))
        ->tag('twig.runtime');
};
