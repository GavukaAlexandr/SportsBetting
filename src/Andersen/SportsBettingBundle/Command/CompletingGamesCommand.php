<?php

namespace Andersen\SportsBettingBundle\Command;

use Andersen\SportsBettingBundle\Entity\Bet;
use Andersen\SportsBettingBundle\Entity\Coefficient;
use Andersen\SportsBettingBundle\Entity\Game;
use Andersen\SportsBettingBundle\Entity\Team;
use Andersen\SportsBettingBundle\Entity\TeamResult;
use Andersen\SportsBettingBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;


class CompletingGamesCommand extends Command
{
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        parent::__construct();
        $this->em = $entityManager;
    }

    protected function configure()
    {
        // try to avoid work here (e.g. database query)
        // this method is *always* called - see warning below

        $this
            // the name of the command (the part after "bin/console")
            ->setName('Sport:Completing-Games')
            // the short description shown while running "php bin/console list"
            ->setDescription('the completion of the games given the time of the games.')
            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp("This command allows completion of the games given the time of the games");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // вибрать ігри час яких завершився, і рандомно призначити команду переможця
        $gamesWithElapsedTime = $this->em->getRepository('SportsBettingBundle:Game')->findGamesWithElapsedTime();

        /** @var Game $game */
        foreach ($gamesWithElapsedTime as $game) {
            $teamsInGame = $this->em->getRepository('SportsBettingBundle:Team')->findTeamsInGame($game->getId());

            /** @var array $teams from game */
            $teams = [];

            /** @var Team $team */
            foreach ($teamsInGame as $team) {
                $teams[] = $team;
            }

            /** Rand team winner or draw */
            $rand = rand(1, 10);
            if ($rand > 1) {
                $teamWinner = 0;
            } else {
                $winner = array_rand($teams);
                $teamWinner = $teams[$winner];

            }

            /** write result in DB */

            if ($teamWinner instanceof Team) {
                $game->setTeamWinner($teamWinner);
            } elseif ($teamWinner == 0) {
                $game->setTeamWinner(null);
            }
            $game->setGameResult(true);
            $this->em->persist($game);

            foreach ($teams as $team) {
                $teamId = intval($team->getId());
                if ($teamWinner instanceof Team) {
                    $winnerId = clone $teamWinner;
                    $winnerId = intval($winnerId->getId());
                } else {
                    $winnerId = intval($teamWinner);
                }

                $teamResult = new TeamResult();
                $teamResult->setGame($game);
                $teamResult->setTeam($team);

                if ($teamId === $winnerId){
                    $teamResult->setGameResult(1);
                } elseif ($winnerId === 0) {
                    $teamResult->setGameResult(0);
                } else {
                    $teamResult->setGameResult(2);
                }

                $this->em->persist($teamResult);
                $this->em->flush();
                $this->giveBenefits($game->getId());
            }
        }

    }

    private function giveBenefits($gameId)
    {
        //todo вибрать всіх юзерів які ставили на гру
        /** @var Bet $users */
        $usersBet = $this->em->getRepository('SportsBettingBundle:Bet')->selectUsersByGameId($gameId);
        $users = [];

        /** @var Bet $user */
        foreach ($usersBet as $user) {
            $users[$user->getUser()->getId()] = $user->getUser();
        }

        //todo вибрать команду яка виграла у грі і записати її в $teamId
        /** @var Game $teamId */
        $teamId = $this->em->getRepository('SportsBettingBundle:Game')->selectTeamWinnerByGameId($gameId);
        $teamId = $teamId->getTeamWinner();

        /** @var Bet $user */
        foreach ($users as $user) {
            //todo вибрать всі ставки юзера на команду яка виграла у грі
            $userBets = $this->em->getRepository('SportsBettingBundle:Bet')->selectUserBetsInTeamInGame($user->getId(), $teamId, $gameId);

            //todo знайти коефіцієнт для команди цеї гри
            /** @var Coefficient $teamCoefficient */
            $teamCoefficient = $this->em->getRepository('SportsBettingBundle:Coefficient')->selectTeamCoefficientByGameId($gameId, $teamId);
            $teamCoefficient = $teamCoefficient->getValue();

            //todo перемножити кожну ставку і записати виграш юзерові в базу
            /** all $userBet * $teamCoefficient and write this in db */
            $allMoneyInUserBets = null;

            /** @var Bet $userBet */
            foreach ($userBets as $userBet) {
                $allMoneyInUserBets = $allMoneyInUserBets + $userBet->getMoney();
            }

            $resultBets = $allMoneyInUserBets * $teamCoefficient;

            /** @var User $userMoney */
            $userMoney = $user->getMoney() + $resultBets;

            $user->setMoney($userMoney);
            $this->em->persist($user);
            $this->em->flush();
        }
    }
}
