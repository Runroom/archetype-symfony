<?php

declare(strict_types=1);

namespace Runroom\UserBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * @phpstan-type UserBundleConfiguration = array{
 *     from_email: array{
 *         address: string,
 *         sender_name: string,
 *     },
 *     reset_password: array{
 *         lifetime: int,
 *         throttle_limit: int,
 *         enable_garbage_collection: bool,
 *     }
 * }
 */
final class RunroomUserExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $bundles = $container->getParameter('kernel.bundles');
        \assert(\is_array($bundles));

        $configuration = new Configuration();
        /** @phpstan-var UserBundleConfiguration */
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new PhpFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.php');

        if (isset($bundles['SonataAdminBundle'])) {
            $loader->load('admin.php');

            if (isset($bundles['SymfonyCastsResetPasswordBundle'])) {
                $loader->load('admin_reset_password.php');
            }
        }

        if (isset($bundles['SymfonyCastsResetPasswordBundle'])) {
            $loader->load('reset_password.php');

            $container->getDefinition('runroom_user.reset_password.helper')
                ->setArgument(3, $config['reset_password']['lifetime'])
                ->setArgument(4, $config['reset_password']['throttle_limit']);

            $container->getDefinition('runroom_user.reset_password.cleaner')
                ->setArgument(1, $config['reset_password']['enable_garbage_collection']);
        }

        $container->getDefinition('runroom_user.service.mailer')
            ->setArgument(3, $config['from_email']['address'])
            ->setArgument(4, $config['from_email']['sender_name']);
    }
}
