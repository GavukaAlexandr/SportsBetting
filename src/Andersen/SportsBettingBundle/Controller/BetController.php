<?php

namespace Andersen\SportsBettingBundle\Controller;

use Andersen\SportsBettingBundle\Entity\Bet;
//use Andersen\SportsBettingBundle\Repository\SportRepository;
//use Andersen\SportsBettingBundle\SportsBettingBundle;
use Andersen\SportsBettingBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Andersen\SportsBettingBundle\Entity\Sport;
//use Symfony\Component\BrowserKit\Request;
//use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

//use Symfony\Component\HttpKernel\Tests\Fixtures\Controller\NullableController;


class BetController extends Controller
{
    /**
     * @return JsonResponse
     *
     * /sports
     *
     * get all sports
     */
    public function getSportsAction()
    {
        $allSports = $this->getDoctrine()
            ->getManager()
            ->getRepository('SportsBettingBundle:Sport')
            ->findAllSports();
        $response = new JsonResponse($allSports);
        return $response;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * /{url}
     *
     * get template for angular js
     */
    public function frontendAction()
    {
        return $this->render('@SportsBetting/Bet/index.html.twig');
    }

    /**
     * @param $sportId
     * @return JsonResponse
     *
     * /sports/{sportId}/bets
     *
     * get bets of sport type
     */
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

    /**
     * @param $sportId
     * @return JsonResponse
     *
     * /sports/{sportId}/games
     *
     * get games of sport type
     */
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

    /**
     * @param $sportId
     * @param $gameId
     * @return JsonResponse
     *
     * /sports/{sportId}/game/{gameId}/bets
     *
     * get bets of gameId and sportId
     */
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

    /**
     * @return JsonResponse
     *
     * /sports/games
     *
     * get all games
     */
    public function getGamesAction()
    {
        $query = $this->getDoctrine()->getManager()->getRepository('SportsBettingBundle:Game')->findAll();
        $response = new JsonResponse($query);
        return $response;
    }

    /**
     * @return JsonResponse
     *
     * /sports/bets
     *
     * get all bets
     */
    public function getBetsAction()
    {
        $query = $this->getDoctrine()->getManager()->getRepository('SportsBettingBundle:Bet')->findAll();
        $response = new JsonResponse($query);
        return $response;
    }

    /**
     * @param $sportId
     * @param $gameId
     * @return JsonResponse
     *
     * /sports/{sportId}/game/{gameId}/teams
     *
     * get teams of gameId and sportId
     */
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

    /**
     * @param $userId
     * @return JsonResponse
     *
     * /user/{userId}/money
     *
     * get(show) user money
     */
    public function getUserMoneyAction($userId)
    {
        $query = $this->getDoctrine()->getRepository('SportsBettingBundle:User')->find($userId);
        $response = new JsonResponse($query);
        return $response;
    }

    /**
     * @param $userId
     *
     * set money
     */
    public function setUserMoneyAction($userId)
    {

    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * /sports/game/{gameId}/team/{teamId}/bet
     *
     * create bet
     */
    public function createBetAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $gameId = $request->request->get('game_id');
        $betValue = $request->request->get('bet_value');
        $money = $request->request->get('money');

        $coefficient = $this->getDoctrine()->getRepository('SportsBettingBundle:Coefficient')
            ->getTeamOfTypeCoefficient($gameId, $betValue);

//        $team = $this->getDoctrine()->getRepository('SportsBettingBundle:Team')->findOneBy(['id' => $teamId]);
        $game = $this->getDoctrine()->getRepository('SportsBettingBundle:Game')->findOneBy(['id' => $gameId]);


        $bet = new Bet();
        $bet->setTeam($coefficient->getTeam());
        $bet->setGame($game);
        $bet->setBetsValue($betValue);
        $bet->setMoney($money);

        $em = $this->getDoctrine()->getManager();
        $em->persist($bet);
        $em->flush();

        $response = new JsonResponse(['status' => 'ok']);
        return $response;
    }

    /**
     * @param Request $request
     *
     * /register
     *
     * register user
     */
    public function registerUserAction(Request $request)
    {
        $apiKey = $request->headers->get('apikey');

        $userName = $request->request->get('name');
        $userEmail = $request->request->get('email');
        $userPassword = $request->request->get('password');



        $checkExistenceUser = $this->getDoctrine()->getRepository("SportsBettingBundle:User")->findOneBy(['email' => $userEmail]);

        if ($checkExistenceUser == NULL) {
            $registerUser = new User();
            $registerUser->setName($userName);
            $registerUser->setPassword($userPassword);
            $registerUser->setEmail($userEmail);

            $em = $this->getDoctrine()->getManager();
            $em->persist($registerUser);
            $em->flush();
        }
    }
}
