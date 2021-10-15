<?php

declare(strict_types=1);

namespace Runroom\UserBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class RolesMatrixExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('renderMatrix', [RolesMatrixRuntime::class, 'renderMatrix']),
            new TwigFunction('renderRolesList', [RolesMatrixRuntime::class, 'renderRolesList']),
        ];
    }
}
