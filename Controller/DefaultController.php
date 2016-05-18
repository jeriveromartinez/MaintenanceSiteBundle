<?php

namespace J3rm\MaintenanceSiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/lolo")
     */
    public function indexAction()
    {
        return $this->render('J3rmMaintenanceSiteBundle:Default:index.html.twig');
    }

    /**
     * @Route("/admin")
     */
    public function permitAction()
    {
        return $this->render('J3rmMaintenanceSiteBundle:Default:index.html.twig');
    }

    /**
     * @Route("login", name="login")
     */
    public function loginAction()
    {
        $helper = $this->get('security.authentication_utils');

        return $this->render('@J3rmMaintenanceSite/Default/login.html.twig',
            ['last_username' => $helper->getLastUsername(),
                'error' => $helper->getLastAuthenticationError()]);
    }

    /**
     * @Route("/offline", name="offline")
     * @return Response
     * @throws \InvalidArgumentException
     */
    public function offlineAction()
    {
        return new Response('Offline');
    }
}
