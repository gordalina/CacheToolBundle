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

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class CacheToolExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $container->setParameter('cachetool.temp_dir', $config['temp_dir']);
        $container->setParameter('cachetool.adapter.fastcgi.connection', $config['fastcgi']);

        switch ($config['adapter']) {
            case 'cli':
                $container->setAlias('cachetool.default_adapter', 'cachetool.adapter.cli');
                break;

            case 'fastcgi':
                $container->setAlias('cachetool.default_adapter', 'cachetool.adapter.fastcgi');
        }
    }
}
