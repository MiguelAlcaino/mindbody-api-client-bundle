<?php

namespace MiguelAlcaino\MindbodyApiClientBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $root        = $treeBuilder->root('miguel_alcaino_mindbody_api_client');

        $root
            ->children()
                ->arrayNode('credentials')
                    ->children()
                        ->scalarNode('source_name')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('source_password')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('admin_user_name')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('admin_user_password')->isRequired()->cannotBeEmpty()->end()
                        ->arrayNode('sites_ids')->scalarPrototype()->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
