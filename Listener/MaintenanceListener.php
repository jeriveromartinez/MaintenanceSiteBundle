<?php
/**
 * Created by PhpStorm.
 * User: julio
 * Date: 5/18/16
 * Time: 9:51 AM
 */

namespace J3rm\MaintenanceSiteBundle\Listener;

use Doctrine\ORM\EntityManager;
use Exception;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class MaintenanceListener
{
    private $checker;
    private $entityManager;
    /**
     * @var Router
     */
    private $router;
    private $pathEnable, $roles, $maintenance, $databaseAttribute;
    private $disabled = false;

    /**
     * MaintenanceListener constructor.
     * @param AuthorizationChecker $checker
     * @param EntityManager $entityManager
     * @param Router $router
     * @param $pathEnable
     * @param $roles
     * @param $maintenance
     * @param $databaseAttribute
     * @throws \Symfony\Component\Routing\Exception\InvalidParameterException
     * @throws \Symfony\Component\Routing\Exception\MissingMandatoryParametersException
     * @throws \Symfony\Component\Routing\Exception\RouteNotFoundException
     */
    public function __construct(AuthorizationChecker $checker, EntityManager $entityManager,
                                Router $router, $pathEnable, $roles, $maintenance,
                                $databaseAttribute)
    {
        $this->checker = $checker;
        $this->entityManager = $entityManager;
        $this->router = $router;
        $this->pathEnable = $pathEnable;
        $this->roles = $roles;
        $this->maintenance = $maintenance;
        $this->databaseAttribute = $databaseAttribute;
    }

    /**
     * @param GetResponseEvent $event
     * @throws NotFoundResourceException
     * @throws ServiceUnavailableHttpException
     * @throws \InvalidArgumentException
     * @throws \Exception
     * @throws \RuntimeException
     * @throws \Twig_Error
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        if ($this->isOffline() and !$this->isRouteOffline($request) and !$this->isPermitUrl($request) and !$this->isPermitRole()) {
            $this->disabled = true;
            $url = $this->router->generate('offline');
            $event->setResponse(new RedirectResponse($url), 503);
        }
        $this->isRouteOffline($request);
        return;
    }

    private function isPermitUrl($request)
    {
        $this->pathEnable[] = $this->router->generate('offline');
        $this->pathEnable[] = '/js/';
        $this->pathEnable[] = '/css/';
        $this->pathEnable[] = '/bundle/';
        $this->pathEnable[] = '/_wdt/';

        foreach ($this->pathEnable as $path)
            if (preg_match('{' . $path . '}', $request->getPathInfo()))
                return true;
        return false;
    }

    public function isRouteOffline(Request $request)
    {
        if (preg_match('{' . $this->router->generate('offline') . '}', $request->getRequestUri()))
            return true;
        return false;
    }

    private function isPermitRole()
    {
        foreach ($this->roles as $role) {
            if ($this->checker->isGranted($role))
                return true;
        }
        return false;
    }

    /**
     * @return bool
     * @throws NotFoundResourceException
     */
    private function isOffline()
    {
        if (isset($this->maintenance) and $this->maintenance == true)
            return true;
        if (isset($this->databaseAttribute))
            return $this->parameterDB();
        return false;
    }

    /**
     * @return bool
     * @throws Exception
     */
    private function parameterDB()
    {
        try {
            $array = explode(':', $this->databaseAttribute);
            return $this->entityManager->createQueryBuilder('q')
                ->select('offline.' . $array[2])->from("$array[0]:$array[1]", 'offline')
                ->getQuery()->getSingleScalarResult();
        } catch (Exception $e) {
            return false;
        }
    }
}