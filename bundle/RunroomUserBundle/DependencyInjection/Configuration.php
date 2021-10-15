<?php

declare(strict_types=1);

namespace Runroom\UserBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * @psalm-suppress PossiblyNullReference, PossiblyUndefinedMethod
     *
     * @see https://github.com/psalm/psalm-plugin-symfony/issues/174
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('runroom_user');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode->children()
            ->arrayNode('from_email')
                ->isRequired()
                ->children()
                    ->scalarNode('address')
                        ->isRequired()
                        ->cannotBeEmpty()
                    ->end()
                    ->scalarNode('sender_name')
                        ->isRequired()
                        ->cannotBeEmpty()
                    ->end()
                ->end()
            ->end()
            ->arrayNode('reset_password')
                ->addDefaultsIfNotSet()
                ->children()
                    ->integerNode('lifetime')
                        ->isRequired()
                        ->defaultValue(3600)
                    ->end()
                    ->integerNode('throttle_limit')
                        ->isRequired()
                        ->defaultValue(3600)
                    ->end()
                    ->booleanNode('enable_garbage_collection')
                        ->isRequired()
                        ->defaultValue(true)
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
