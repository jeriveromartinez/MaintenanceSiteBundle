<?php
/**
 * Created by PhpStorm.
 * User: julio
 * Date: 10/06/16
 * Time: 10:44
 */

namespace J3rm\MaintenanceSiteBundle\Routing;

use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class ExtraLoader extends Loader
{
    private $loaded = false;

    /**
     * Loads a resource.
     *
     * @param mixed $resource The resource
     * @param string|null $type The resource type or null if unknown
     *
     * @return RouteCollection
     * @throws \Exception If something went wrong
     */
    public function load($resource, $type = null)
    {
        if (true === $this->loaded) {
            throw new \RuntimeException('Do not add the "extra" loader twice');
        }

        $routes = new RouteCollection();

        // prepare a new route
        $path = '/offline';
        $defaults = array(
            '_controller' => 'J3rmMaintenanceSiteBundle:Offline:offline',
        );
        $route = new Route($path, $defaults);

        // add the new route to the route collection
        $routes->add('offline', $route);

        $this->loaded = true;

        return $routes;
    }

    /**
     * Returns whether this class supports the given resource.
     *
     * @param mixed $resource A resource
     * @param string|null $type The resource type or null if unknown
     *
     * @return bool True if this class supports the given resource, false otherwise
     */
    public function supports($resource, $type = null)
    {
        return 'extra' === $type;
    }
}