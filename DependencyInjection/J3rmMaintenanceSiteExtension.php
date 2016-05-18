<?php

namespace J3rm\MaintenanceSiteBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class J3rmMaintenanceSiteExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $container->setParameter('j3rm_maintenance_site.path_enable', $config['path_enable']);
        $container->setParameter('j3rm_maintenance_site.name_path_offline', $config['name_path_offline']);
        $container->setParameter('j3rm_maintenance_site.roles_enable_offline', $config['roles_enable_offline']);
        $container->setParameter('j3rm_maintenance_site.maintenance', $config['maintenance']);
    }
}
