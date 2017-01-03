<?php

namespace Andersen\SportsBettingBundle\Controller;

use Andersen\SportsBettingBundle\Repository\SportRepository;
use Andersen\SportsBettingBundle\SportsBettingBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Andersen\SportsBettingBundle\Entity\Sport;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\JsonResponse;


class BetController extends Controller
{
    public function indexAction()
    {
        $allSports = $this->getDoctrine()
            ->getManager()
            ->getRepository('SportsBettingBundle:Sport')
            ->findAllSports();
        $response = new JsonResponse($allSports);
        return $response;

    }

    public function frontendAction()
    {
        return $this->render('@SportsBetting/Bet/index.html.twig');
    }

    public function getSportBetsAction($sportId)
    {
        $allBets = $this->getDoctrine()
            ->getManager()
            ->getRepository('SportsBettingBundle:Bet')
            ->findAllBets($sportId);
        $response = new JsonResponse($allBets);
        return $response;
    }
}
