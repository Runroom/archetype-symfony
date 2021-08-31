<?php

declare(strict_types=1);

namespace App\Security\RolesBuilder;

use Sonata\AdminBundle\SonataConfiguration;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/** @phpstan-import-type Role from MatrixRolesBuilder */
class SecurityRolesBuilder
{
    private AuthorizationCheckerInterface $authorizationChecker;
    private SonataConfiguration $configuration;
    private TranslatorInterface $translator;

    /** @var array<string, string[]> */
    private array $rolesHierarchy;

    /** @param array<string, string[]> $rolesHierarchy */
    public function __construct(
        AuthorizationCheckerInterface $authorizationChecker,
        SonataConfiguration $configuration,
        TranslatorInterface $translator,
        array $rolesHierarchy = []
    ) {
        $this->authorizationChecker = $authorizationChecker;
        $this->configuration = $configuration;
        $this->translator = $translator;
        $this->rolesHierarchy = $rolesHierarchy;
    }

    /**
     * @return array<string, array<string, string|bool>>
     *
     * @phpstan-return Role[]
     */
    public function getExpandedRoles(?string $domain = null): array
    {
        $securityRoles = [];
        $hierarchy = $this->getHierarchy();

        foreach ($hierarchy as $role => $childRoles) {
            $translatedRoles = array_map(
                [$this, 'translateRole'],
                $childRoles,
                array_fill(0, \count($childRoles), $domain)
            );

            $translatedRoles = \count($translatedRoles) > 0 ? ': ' . implode(', ', $translatedRoles) : '';
            $securityRoles[$role] = [
                'role' => $role,
                'role_translated' => $role . $translatedRoles,
                'is_granted' => $this->authorizationChecker->isGranted($role),
            ];

            $securityRoles = array_merge(
                $securityRoles,
                $this->getSecurityRoles($hierarchy, $childRoles, $domain)
            );
        }

        return $securityRoles;
    }

    /**
     * @return array<string, array<string, string|bool>>
     *
     * @phpstan-return Role[]
     */
    public function getRoles(?string $domain = null): array
    {
        $securityRoles = [];
        $hierarchy = $this->getHierarchy();

        foreach ($hierarchy as $role => $childRoles) {
            $securityRoles[$role] = $this->getSecurityRole($role, $domain);
            $securityRoles = array_merge(
                $securityRoles,
                $this->getSecurityRoles($hierarchy, $childRoles, $domain)
            );
        }

        return $securityRoles;
    }

    /** @return array<string, string[]> */
    private function getHierarchy(): array
    {
        $roleSuperAdmin = $this->configuration->getOption('role_super_admin');
        \assert(\is_string($roleSuperAdmin));
        $roleAdmin = $this->configuration->getOption('role_super_admin');
        \assert(\is_string($roleAdmin));

        return array_merge([$roleSuperAdmin => [], $roleAdmin => []], $this->rolesHierarchy);
    }

    /**
     * @return array<string, string|bool>
     *
     * @phpstan-return Role
     */
    private function getSecurityRole(string $role, ?string $domain): array
    {
        return [
            'role' => $role,
            'role_translated' => $this->translateRole($role, $domain),
            'is_granted' => $this->authorizationChecker->isGranted($role),
        ];
    }

    /**
     * @param string[][] $hierarchy
     * @param string[] $roles
     *
     * @return array<string, array<string, string|bool>>
     *
     * @phpstan-return Role[]
     */
    private function getSecurityRoles(array $hierarchy, array $roles, ?string $domain): array
    {
        $securityRoles = [];
        foreach ($roles as $role) {
            if (!\array_key_exists($role, $hierarchy) && !isset($securityRoles[$role])) {
                $securityRoles[$role] = $this->getSecurityRole($role, $domain);
            }
        }

        return $securityRoles;
    }

    private function translateRole(string $role, ?string $domain = null): string
    {
        if (null !== $domain) {
            return $this->translator->trans($role, [], $domain);
        }

        return $role;
    }
}
