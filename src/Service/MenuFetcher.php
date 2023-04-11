<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\MenuItem;
use App\Exception\MenuDoesNotMatchException;
use App\Exception\MenuItemNotFoundException;
use App\Exception\MenuNotFoundException;
use App\Exception\MenuTrailDoNotMatchException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

final class MenuFetcher implements MenuFetcherInterface
{
    private const MENU_CLASS = MenuItem::class;

    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function get(Request $request): MenuItem
    {
        $menu = $request->attributes->get('menu');
        $slug = $request->attributes->get('slug');

        if (null === $slug) {
            throw new \InvalidArgumentException(
                'There is no `slug` attributes defined for the current route `%s`.',
                $request->attributes->get('_route', '')
            );
        }

        $currentMenu = $this->getCurrentMenuItem($menu, $slug);

        $this->validate($currentMenu, $slug, $menu);

        return $currentMenu;
    }

    private function getCurrentMenuItem(string $menu, string $slug): MenuItem
    {
        $exploded = explode('/', $slug);
        $last = end($exploded);

        $repository = $this->entityManager->getRepository(self::MENU_CLASS);
        $menuItem = $repository->findOneBy([

            'slug' => $last
        ]);

        dump($menuItem);

        if (null === $menuItem) {
            throw new MenuItemNotFoundException($last);
        }

        return $menuItem;
    }

    private function validate(MenuItem $menuItem, string $slug, string $menu): void
    {
        $repository = $this->entityManager->getRepository(self::MENU_CLASS);

        $menuPath = $repository->getPath($menuItem);
        $rootMenu = array_shift($menuPath);

        if ($rootMenu->getSlug() !== $menu) {
            throw new MenuDoesNotMatchException($rootMenu, $menu);
        }

        $slugPath = explode('/', $slug);

        foreach ($menuPath as $key => $menuItem) {
            if ($menuItem->getSlug() !== $slugPath[$key]) {
                throw new MenuTrailDoNotMatchException($menuItem, $slugPath[$key]);
            }
        }
    }
}
