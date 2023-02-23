<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\MenuItem;
use App\Exception\MenuNotFoundException;
use Symfony\Component\HttpFoundation\Request;

interface MenuFetcherInterface
{
    /**
     * @throws MenuNotFoundException if no menu was found for the request provided
     */
    public function get(Request $request): MenuItem;
}
