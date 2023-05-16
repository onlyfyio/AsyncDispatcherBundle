<?php

namespace BBIT\AsyncDispatcherBundle\Tests\App;

use BBIT\AsyncDispatcherBundle\BBITAsyncDispatcherBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\SecurityBundle\SecurityBundle;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // Dependencies
            new FrameworkBundle(),
            new SecurityBundle(),
            // My Bundle to test
            new BBITAsyncDispatcherBundle(),
        );

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        // We don't need that Environment stuff, just one config
        $loader->load(__DIR__.'/config/config.yml');
    }
}

