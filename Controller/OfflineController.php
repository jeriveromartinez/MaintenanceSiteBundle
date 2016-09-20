<?php

namespace J3rm\MaintenanceSiteBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class OfflineController extends Controller
{
    /**
     * @Route("/{_locale}/offline/", name="offline")
     * @return Response
     * @throws \Symfony\Component\Translation\Exception\NotFoundResourceException
     */
    public function offlineAction()
    {
        try {
            return $this->render('TwigBundle:Exception:error503.html.twig');
        } catch (\Exception $e) {
            throw new NotFoundResourceException('Template error 503 not found');
        }
    }
}
