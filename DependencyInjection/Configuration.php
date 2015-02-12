<?php

/*
 * This file is part of CacheToolBundle.
 *
 * (c) Samuel Gordalina <samuel.gordalina@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CacheTool\Bundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('cachetool');

        $rootNode
            ->children()
                ->scalarNode('adapter')
                    ->defaultValue('fastcgi')
                    ->validate()
                        ->ifNotInArray(array('cli', 'fastcgi'))
                        ->thenInvalid('Adapter `%s` is not valid')
                    ->end()
                ->end()
                ->scalarNode('fastcgi')
                    ->defaultValue('127.0.0.1:9000')
                ->end()
                ->scalarNode('temp_dir')
                    ->defaultValue(null)
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
