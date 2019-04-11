<?php

namespace Runroom\BaseBundle\DependencyInjection;

use Runroom\BaseBundle\ViewModel\PageViewModel;
use Runroom\BaseBundle\ViewModel\PageViewModelInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('runroom_base');

        $treeBuilder
            ->getRootNode()
                ->children()
                    ->scalarNode('page_view_model')
                        ->cannotBeEmpty()
                        ->defaultValue(PageViewModel::class)
                        ->validate()
                            ->ifTrue(function ($config) {
                                return !\is_a($config, PageViewModelInterface::class, true);
                            })
                            ->thenInvalid('%s must extend ' . PageViewModelInterface::class)
                        ->end()
                    ->end()
                ->end();

        return $treeBuilder;
    }
}
