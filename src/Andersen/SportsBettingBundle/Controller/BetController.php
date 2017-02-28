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


    public function getCoefficientsForTeamsInGameIdAction($sportId, $gameId)
    {
        $query = $this->getDoctrine()->getRepository('SportsBettingBundle:Coefficient')->findBy(['game' => $gameId]);

        if ($query[0]->getTeam() == null){
            $query[0]->setTeam(['id' => 'null', 'name' => 'Draw']);
        }

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
     * @param Request $request
     *
     * /sports/game/{gameId}/team/{teamId}/bet
     *
     * create bet
     */
    public function createBetAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $parametersAsArray = [];
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);
        }

        /**
         * Get POST JSON object
         */
        $coefficientId = $parametersAsArray[coefficient_id];
        $moneyToBet = $parametersAsArray[money];
        $userId = $parametersAsArray[user_id];



        //todo get user from http headers API token

        /**
         * Get User Of Id
         */
        $user = $this->getDoctrine()
            ->getManager()
            ->getRepository('SportsBettingBundle:User')
            ->findOneBy(['id' => $userId]);

        /**
         * If User have money in bet
         */
        $userMoney = $user->getMoney();
        if ($userMoney >= $moneyToBet and $moneyToBet > 0){
            /**
             * take money in User for betting
             */
            $userMoneyResult = $userMoney  - $moneyToBet;
            $user->setMoney($userMoneyResult);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);

            /**
             * Get coefficient, gameId, teamId from coefficientId
             */
            $coefficient = $this->getDoctrine()
                ->getRepository('SportsBettingBundle:Coefficient')
                ->getTeamOfTypeCoefficient($coefficientId);

//            /**
//             * Get Game object from GameEntity by Id
//             */
//            $game = $this->getDoctrine()->getRepository('SportsBettingBundle:Game')->findOneBy(['id' => $gameId]);

            /**
             * Create Bet
             */
            $bet = new Bet();
            $bet->setTeam($coefficient->getTeam());
            $bet->setGame($coefficient->getGame());
            $bet->setUser($user);
            $bet->setCoefficient($coefficient);
            $bet->setMoney($moneyToBet);

            $em = $this->getDoctrine()->getManager();
            $em->persist($bet);
            $em->flush();

            $response = new JsonResponse(['status' => 'the bet of successfully adopted!']);
            return $response;
        } else {
            $message = "Sorry, you don`t have enough money to bet";
            return new JsonResponse(['status' => $message]);
        }
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
