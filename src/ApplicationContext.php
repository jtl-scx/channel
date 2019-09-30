<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/09
 */

namespace JTL\SCX\Channel;

use JTL\SCX\Lib\Channel\Core\AbstractApplicationContext;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ApplicationContext extends AbstractApplicationContext
{
    /**
     * @param ContainerBuilder $containerBuilder
     * @param LoaderInterface $loader
     * @throws \Exception
     */
    protected function configureContainer(ContainerBuilder $containerBuilder, LoaderInterface $loader): void
    {
        parent::configureContainer($containerBuilder, $loader);
        $loader->load(__DIR__ . '/../config/service.yaml');
    }
}
