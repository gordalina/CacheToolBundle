<?php

namespace CacheTool\Bundle;

use Symfony\Component\Console\Application;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\HttpKernel\Kernel;

class CacheToolBundle extends Bundle
{
    public function registerCommands(Application $application)
    {
        // Symfony 2.4 allows us to register commands through the service container
        if (version_compare(Kernel::VERSION, '2.4.0') > 0) {
            return parent::registerCommands($application);
        }

        // evil magic stuff
        $rootDir = $this->container->getParameter('kernel.root_dir');
        $cacheToolDir = $rootDir . '/../vendor/gordalina/cachetool';
        $commandsDir = $cacheToolDir . '/src/CacheTool/Command';

        if (!is_dir($dir = $commandsDir)) {
            return;
        }

        $finder = new Finder();
        $finder->files()->name('*Command.php')->in($dir);

        $ns = '\\CacheTool\\Command';
        foreach ($finder as $file) {
            $r = new \ReflectionClass($ns.'\\'.$file->getBasename('.php'));
            if ($r->isSubclassOf('Symfony\\Component\\Console\\Command\\Command') && !$r->isAbstract() && !$r->getConstructor()->getNumberOfRequiredParameters()) {
                $application->add($r->newInstance());
            }
        }
    }
}
