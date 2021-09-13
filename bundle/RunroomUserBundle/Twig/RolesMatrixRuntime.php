<?php

declare(strict_types=1);

namespace Runroom\UserBundle\Twig;

use Runroom\UserBundle\Security\RolesBuilder\MatrixRolesBuilder;
use Symfony\Component\Form\FormView;
use Twig\Environment;
use Twig\Extension\RuntimeExtensionInterface;

final class RolesMatrixRuntime implements RuntimeExtensionInterface
{
    private Environment $twig;
    private MatrixRolesBuilder $rolesBuilder;

    public function __construct(
        Environment $twig,
        MatrixRolesBuilder $rolesBuilder
    ) {
        $this->twig = $twig;
        $this->rolesBuilder = $rolesBuilder;
    }

    public function renderRolesList(FormView $form): string
    {
        $roles = $this->rolesBuilder->getRoles();
        foreach ($roles as $role => $attributes) {
            if (isset($attributes['admin_label'])) {
                unset($roles[$role]);
                continue;
            }

            $roles[$role] = $attributes;
            foreach ($form->getIterator() as $child) {
                if ($child->vars['value'] === $role) {
                    $roles[$role]['form'] = $child;
                }
            }
        }

        return $this->twig->render('@RunroomUser/admin/roles_matrix_list.html.twig', [
            'roles' => $roles,
        ]);
    }

    public function renderMatrix(FormView $form): string
    {
        $groupedRoles = [];
        foreach ($this->rolesBuilder->getRoles() as $role => $attributes) {
            if (!isset($attributes['admin_label'])) {
                continue;
            }

            $groupedRoles[$attributes['admin_label']][$role] = $attributes;
            foreach ($form->getIterator() as $child) {
                if ($child->vars['value'] === $role) {
                    $groupedRoles[$attributes['admin_label']][$role]['form'] = $child;
                }
            }
        }

        return $this->twig->render('@RunroomUser/admin/roles_matrix.html.twig', [
            'grouped_roles' => $groupedRoles,
            'permission_labels' => $this->rolesBuilder->getPermissionLabels(),
        ]);
    }
}
