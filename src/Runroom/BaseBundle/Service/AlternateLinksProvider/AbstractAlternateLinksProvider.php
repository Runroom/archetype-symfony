<?php

namespace Runroom\BaseBundle\Service\AlternateLinksProvider;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\RequestStack;

abstract class AbstractAlternateLinksProvider implements AlternateLinksProviderInterface
{
    protected static $routes = [];
    protected $router;
    protected $request_stack;
    protected $locales;

    public function __construct(
        Router $router,
        RequestStack $request_stack,
        array $locales
    ) {
        $this->router = $router;
        $this->request_stack = $request_stack;
        $this->locales = $locales;
    }

    public function providesAlternateLinks($base_route)
    {
        return in_array($base_route, static::$routes);
    }

    public function findAlternateLinksFor($base_route, $model)
    {
        $alternate_links = [];

        try {
            foreach ($this->locales as $locale) {
                $alternate_links[$locale] = $this->router->generate(
                    $base_route . '.' . $locale,
                    array_merge(
                        $this->getRouteParameters($model, $locale),
                        $this->getQueryParameters()
                    ),
                    Router::ABSOLUTE_URL
                );
            }
        } catch (\Exception $e) {
        }

        return $alternate_links;
    }

    abstract public function getRouteParameters($model, $locale);

    private function getQueryParameters()
    {
        return $this->request_stack->getCurrentRequest()->query->all();
    }
}
