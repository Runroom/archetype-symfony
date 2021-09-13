<?php

declare(strict_types=1);

namespace Runroom\UserBundle\Twig;

use Runroom\UserBundle\Entity\User;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Admin\Pool;

final class GlobalVariables
{
    private Pool $pool;

    public function __construct(Pool $pool)
    {
        $this->pool = $pool;
    }

    /** @phpstan-return AdminInterface<object> */
    public function getUserAdmin(): AdminInterface
    {
        return $this->pool->getAdminByClass(User::class);
    }
}
