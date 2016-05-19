<?php

namespace J3rm\MaintenanceSiteBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     * @throws \RuntimeException
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('j3rm_maintenance_site');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        $rootNode->children()
            ->scalarNode('path_enable')->defaultValue('/manager')->end()
            ->arrayNode('roles_enable_offline')->prototype('scalar')->end()
            ->defaultValue(array('ROLE_ADMIN'))->end()
            ->booleanNode('maintenance')->end()
            ->scalarNode('database_offline')->defaultValue('AppBundle:SiteEntity:ColumnName')->end();

        return $treeBuilder;
    }
}
