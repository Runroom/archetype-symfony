<?php

declare(strict_types=1);

namespace App\Exception;

use App\Entity\MenuItem;

final class MenuTrailDoNotMatchException extends \InvalidArgumentException
{
    public function __construct(MenuItem $menuItem, string $slug)
    {
        parent::__construct(sprintf(
            'The slug trail `%s` does not match the menu item `%s`.',
            $slug,
            $menuItem->getTitle()
        ));
    }
}
