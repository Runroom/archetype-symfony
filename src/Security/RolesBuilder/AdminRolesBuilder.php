<?php

declare(strict_types=1);

namespace App\Security\RolesBuilder;

use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Admin\Pool;
use Sonata\AdminBundle\SonataConfiguration;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/** @phpstan-import-type Role from MatrixRolesBuilder */
class AdminRolesBuilder
{
    private AuthorizationCheckerInterface $authorizationChecker;
    private Pool $pool;
    private SonataConfiguration $configuration;
    private TranslatorInterface $translator;

    public function __construct(
        AuthorizationCheckerInterface $authorizationChecker,
        Pool $pool,
        SonataConfiguration $configuration,
        TranslatorInterface $translator
    ) {
        $this->authorizationChecker = $authorizationChecker;
        $this->pool = $pool;
        $this->configuration = $configuration;
        $this->translator = $translator;
    }

    /** @return array<string, string> */
    public function getPermissionLabels(): array
    {
        $permissionLabels = [];
        foreach ($this->getRoles() as $attributes) {
            if (isset($attributes['label'])) {
                $permissionLabels[$attributes['label']] = $attributes['label'];
            }
        }

        return $permissionLabels;
    }

    /**
     * @return array<string, array<string, string|bool>>
     *
     * @phpstan-return Role[]
     */
    public function getRoles(?string $domain = null): array
    {
        $adminRoles = [];
        foreach ($this->pool->getAdminServiceIds() as $id) {
            $admin = $this->pool->getInstance($id);
            $securityHandler = $admin->getSecurityHandler();
            $baseRole = $securityHandler->getBaseRole($admin);
            foreach (array_keys($admin->getSecurityInformation()) as $key) {
                $role = sprintf($baseRole, $key);
                $adminRoles[$role] = [
                    'role' => $role,
                    'label' => $key,
                    'role_translated' => $this->translateRole($role, $domain),
                    'is_granted' => $this->isMaster($admin) || $this->authorizationChecker->isGranted($role),
                    'admin_label' => $admin->getTranslator()->trans($admin->getLabel() ?? ''),
                ];
            }
        }

        return $adminRoles;
    }

    /** @phpstan-param AdminInterface<object> $admin */
    private function isMaster(AdminInterface $admin): bool
    {
        return $admin->isGranted('MASTER') || $admin->isGranted('OPERATOR')
            || $this->authorizationChecker->isGranted($this->configuration->getOption('role_super_admin'));
    }

    private function translateRole(string $role, ?string $domain = null): string
    {
        if (null !== $domain) {
            return $this->translator->trans($role, [], $domain);
        }

        return $role;
    }
}
