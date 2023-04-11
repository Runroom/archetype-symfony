<?php

declare(strict_types=1);

namespace App\Exception;

final class MenuItemNotFoundException extends \InvalidArgumentException
{
    public function __construct(string $slug)
    {
        parent::__construct(sprintf(
            'The menu item with the slug `%s` does not exist.',
            $slug
        ));
    }
}
