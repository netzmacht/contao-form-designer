<?php

declare(strict_types=1);

namespace Netzmacht\Contao\FormDesigner\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('netzmacht_contao_form_designer');
        $rootNode    = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->arrayNode('elements')
                    ->info('List of supported content elements')
                    ->scalarPrototype()->end()
                ->end()
                ->arrayNode('modules')
                    ->info('List of supported frontend modules')
                    ->scalarPrototype()->end()
                ->end()
                ->arrayNode('virtual_widgets')
                    ->info('List of virtual form widgets')
                    ->scalarPrototype()->end()
                ->end()
                ->arrayNode('widgets')
                    ->info('Widget configuration')
                    ->arrayPrototype()
                        ->children()
                            ->booleanNode('help')
                                ->info('Widget supports help message')
                                ->defaultValue(false)
                            ->end()
                            ->arrayNode('templates')
                                ->info('Key value map of templates')
                                ->scalarPrototype()->end()
                            ->end()
                            ->arrayNode('attributes')
                                ->info('Define custom control attributes')
                                ->arrayPrototype()
                                    ->children()
                                        ->scalarNode('key')
                                            ->info('The widget configuration key of the value')
                                        ->end()
                                        ->variableNode('value')
                                            ->info('The attribute value')
                                        ->end()
                                        ->arrayNode('filters')
                                            ->info('List of filters which needs to be applied')
                                            ->example(['specialchars'])
                                            ->enumPrototype()
                                                ->values(['specialchars'])
                                            ->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                            ->arrayNode('palettes')
                                ->info('Extra palettes assigned with this widget type')
                                ->scalarPrototype()->end()
                            ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
