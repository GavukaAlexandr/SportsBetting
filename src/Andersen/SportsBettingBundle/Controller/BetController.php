<?php

namespace Andersen\SportsBettingBundle\Controller;

use Andersen\SportsBettingBundle\Entity\Bet;
use Andersen\SportsBettingBundle\Repository\SportRepository;
use Andersen\SportsBettingBundle\SportsBettingBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Andersen\SportsBettingBundle\Entity\Sport;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Tests\Fixtures\Controller\NullableController;


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
        $allBets = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('SportsBettingBundle:Bet')
            ->findAllBets($sportId);
        $response = new JsonResponse($allBets);
        return $response;
    }

    public function getSportGamesAction($sportId)
    {
        $sportGame = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('SportsBettingBundle:Game')
            ->findAllGamesOfSportType($sportId);
        $response = new JsonResponse($sportGame);
        return $response;
    }

    public function getSportGameBetsAction($sportId, $gameId)
    {
        $sportGameBets = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('SportsBettingBundle:Bet')
            ->findSportGameBets($sportId, $gameId);
        $response = new JsonResponse($sportGameBets);
        return $response;
    }

    public function getGamesAction()
    {
        $query = $this->getDoctrine()->getManager()->getRepository('SportsBettingBundle:Game')->findAll();
        $response = new JsonResponse($query);
        return $response;
    }

    public function getBetsAction()
    {
        $query = $this->getDoctrine()->getManager()->getRepository('SportsBettingBundle:Bet')->findAll();
        $response = new JsonResponse($query);
        return $response;
    }

    public function getSportGameTeamsAction($sportId, $gameId)
    {
        $query = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('SportsBettingBundle:Team')
            ->findSportGameTeams($sportId, $gameId);
        $response = new JsonResponse($query);
        return $response;
    }

    public function getUserMoneyAction($userId)
    {
        $query = $this->getDoctrine()->getRepository('SportsBettingBundle:User')->find($userId);
        $response = new JsonResponse($query);
        return $response;
    }

    public function createBetAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $sportId = $request->request->get('sport_id');
        $teamId = $request->request->get('team_id');
        $gameId = $request->request->get('game_id');
        $userId = $request->request->get('user_id');
        $betValue = $request->request->get('bet_value');
        $coefficientValue = $request->request->get('coefficient_value');
        $money = $request->request->get('money');

        $bet = new Bet();
        $bet->setSport($sportId);
        $bet->setTeam($teamId);
        $bet->setGame($gameId);
        $bet->setUser($userId);
        $bet->setBetsValue($betValue);
//        bet->setCoefficient();
        $bet->setMoney($money);

    }
}
