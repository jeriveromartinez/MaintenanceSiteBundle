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
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class MaintenanceListener
{
    private $checker;
    private $entityManager;
    private $pathEnable, $roles, $maintenance, $databaseAttribute;

    /**
     * MaintenanceListener constructor.
     * @param AuthorizationChecker $checker
     * @param EntityManager $entityManager
     * @param $pathEnable
     * @param $roles
     * @param $maintenance
     * @param $databaseAttribute
     * @internal param Router $router
     */
    public function __construct(AuthorizationChecker $checker, EntityManager $entityManager,
                                $pathEnable, $roles, $maintenance, $databaseAttribute)
    {
        $this->checker = $checker;
        $this->entityManager = $entityManager;
        $this->pathEnable = $pathEnable;
        $this->roles = $roles;
        $this->maintenance = $maintenance;
        $this->databaseAttribute = $databaseAttribute;
    }

    /**
     * @param GetResponseEvent $event
     * @throws NotFoundResourceException
     * @throws ServiceUnavailableHttpException
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if ($this->isOffline() and !$this->isPermitUrl($request) and !$this->isPermitRole()) {
            throw new ServiceUnavailableHttpException();
        }
    }

    private function isPermitUrl($request)
    {
        foreach ($this->pathEnable as $path)
            if (preg_match('{' . $path . '}', $request->getPathInfo()))
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
     * @return boolean
     * @throws NotFoundResourceException
     */
    private function parameterDB()
    {
        try {
            $array = explode(':', $this->databaseAttribute);
            return $this->entityManager->createQueryBuilder('q')
                ->select('offline.' . $array[2])->from('J3rmMaintenanceSiteBundle:Sites', 'offline')
                ->getQuery()->getSingleScalarResult();
        } catch (Exception $e) {
            throw new NotFoundResourceException;
        }
    }
}