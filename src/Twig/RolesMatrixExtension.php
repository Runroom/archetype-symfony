<?php

declare(strict_types=1);

namespace App\Twig;

use App\Security\RolesBuilder\MatrixRolesBuilder;
use Symfony\Component\Form\FormView;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class RolesMatrixExtension extends AbstractExtension
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

    public function getFunctions(): array
    {
        return [
            new TwigFunction('renderMatrix', [$this, 'renderMatrix']),
            new TwigFunction('renderRolesList', [$this, 'renderRolesList']),
        ];
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

        return $this->twig->render('sonata/security/admin/roles_matrix_list.html.twig', [
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

        return $this->twig->render('sonata/security/admin/roles_matrix.html.twig', [
            'grouped_roles' => $groupedRoles,
            'permission_labels' => $this->rolesBuilder->getPermissionLabels(),
        ]);
    }
}
