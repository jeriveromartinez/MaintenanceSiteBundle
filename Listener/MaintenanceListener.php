<?php
/**
 * Created by PhpStorm.
 * User: julio
 * Date: 5/18/16
 * Time: 9:51 AM
 */

namespace J3rm\MaintenanceSiteBundle\Listener;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class MaintenanceListener
{
    private $checker;
    private $router;
    private $pathEnable, $pathOffline, $roles, $maintenance;

    /**
     * MaintenanceListener constructor.
     * @param AuthorizationChecker $checker
     * @param Router $router
     * @param $pathEnable
     * @param $pathOffline
     * @param $roles
     * @param $maintenance
     */
    public function __construct(AuthorizationChecker $checker, Router $router,
                                $pathEnable, $pathOffline, $roles, $maintenance)
    {
        $this->checker = $checker;
        $this->router = $router;
        $this->pathEnable = $pathEnable;
        $this->pathOffline = $pathOffline;
        $this->roles = $roles;
        $this->maintenance = $maintenance;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        if ($this->maintenance and !$this->isPermitUrl($request) and !$this->isPermitRole()) {
            $url = $this->router->generate($this->pathOffline);
            $response = new RedirectResponse($url);
            $event->setResponse($response);
        }
    }

    private function isPermitUrl($request)
    {
        if (preg_match('{' . $this->pathEnable . '}', $request->getPathInfo())
            || preg_match('{' . $this->router->generate($this->pathOffline) . '}', $request->getPathInfo())
        )
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
}