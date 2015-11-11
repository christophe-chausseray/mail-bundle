<?php

namespace Chris\Bundle\MailBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('mail');

        $rootNode
            ->children()
                ->arrayNode('sendgrid')
                    ->children()
                        ->canBeEnabled()
                        ->scalarNode('user')->end()
                        ->scalarNode('password')->end()
                        ->arrayNode('options')
                            ->children()
                                ->scalarNode('turn_off_ssl_verification')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
