<?php

namespace PhpDDD\DomainDrivenDesignBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 *
 */
final class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('domain_driven_design');
        $rootNode
            ->children()
                ->booleanNode('command')->defaultTrue()->end()
                ->booleanNode('command_event')->defaultTrue()->end()
                ->booleanNode('event')->defaultTrue()->end()
            ->end();

        return $treeBuilder;
    }
}
