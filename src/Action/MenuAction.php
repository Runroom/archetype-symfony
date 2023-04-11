<?php

declare(strict_types=1);

namespace App\Action;

use App\Service\MenuFetcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class MenuAction extends AbstractController
{
    private MenuFetcherInterface $menuFetcher;

    public function __construct(
        MenuFetcherInterface $menuFetcher,
    ) {
        $this->menuFetcher = $menuFetcher;
    }

    #[Route(
        '/menu/{slug}',
        name: 'menu',
        methods: ['GET'],
        requirements: ['slug' => '.+'],
        defaults: [
            'menu' => 'menu',
        ]
    )]
    public function __invoke(Request $request): Response
    {
        $menu = $this->menuFetcher->get($request);
        dump($menu);

        return new Response();
    }
}
