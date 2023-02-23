<?php

declare(strict_types=1);

namespace App\Exception;

use App\Entity\Menu;

final class MenuDoesNotMatchException extends \InvalidArgumentException
{
    public function __construct(Menu $menu, string $slug)
    {
        parent::__construct(sprintf(
            'The menu `%s` does not match the slug `%s`.',
            $menu->getTitle(),
            $slug
        ));
    }
}
