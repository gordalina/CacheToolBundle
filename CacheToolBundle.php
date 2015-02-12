<?php

/*
 * This file is part of CacheToolBundle.
 *
 * (c) Samuel Gordalina <samuel.gordalina@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CacheTool\Bundle;

use Symfony\Component\Console\Application;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Bundle\FrameworkBundle\Console\Application as FrameworkApplication;

class CacheToolBundle extends Bundle
{
    public function registerCommands(Application $application)
    {
        if (!$application instanceof FrameworkApplication) {
            return parent::registerCommands($application);
        }

        if (!(false === ($apc = $application->getKernel()->getContainer()->getParameter('cachetool.apc'))
            xor false === $application->getKernel()->getContainer()->getParameter('cachetool.opcache'))
        ) {
            return parent::registerCommands($application);
        }

        if (!is_dir($dir = $this->getPath().'/Command')) {
            return;
        }

        $finder = new Finder();
        $finder->files()->name(($apc ? 'Apc' : 'Opcache').'*Command.php')->in($dir);

        $prefix = $this->getNamespace().'\\Command';
        foreach ($finder as $file) {
            $ns = $prefix;
            if ($relativePath = $file->getRelativePath()) {
                $ns .= '\\'.strtr($relativePath, '/', '\\');
            }
            $class = $ns.'\\'.$file->getBasename('.php');
            if ($this->container) {
                $alias = 'console.command.'.strtolower(str_replace('\\', '_', $class));
                if ($this->container->has($alias)) {
                    continue;
                }
            }
            $r = new \ReflectionClass($class);
            if ($r->isSubclassOf('Symfony\\Component\\Console\\Command\\Command') && !$r->isAbstract() && !$r->getConstructor()->getNumberOfRequiredParameters()) {
                $application->add($r->newInstance());
            }
        }

    }
}
