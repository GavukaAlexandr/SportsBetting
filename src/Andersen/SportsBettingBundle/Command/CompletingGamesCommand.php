<?php

namespace Andersen\SportsBettingBundle\Command;

use Andersen\SportsBettingBundle\Entity\Game;
use Andersen\SportsBettingBundle\Entity\Team;
use Andersen\SportsBettingBundle\Entity\TeamResult;
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
            if ($rand > 7) {
                $teamWinner = 0;
            } else {
                $winner = array_rand($teams);
                $teamWinner = $teams[$winner];

            }

            /** write result in DB */
            $game->setTeamWinner($teamWinner);
            $game->setGameResult(true);
            $this->em->persist($game);

            foreach ($teams as $team) {
                $teamForIf = $team->getId();
                if ($teamWinner instanceof Team) {
                    $winnerForIf = $teamWinner->getId();
                }

                if ($teamForIf === $winnerForIf) {
                    $teamResult = new TeamResult();
                    $teamResult->setGame($game);
                    $teamResult->setTeam($team);
                    $teamResult->setGameResult(1);
                } elseif ($teamWinner == 0) {
                    $teamResult = new TeamResult();
                    $teamResult->setGame($game);
                    $teamResult->setTeam($team);
                    $teamResult->setGameResult(0);
                } else {
                    $teamResult = new TeamResult();
                    $teamResult->setGame($game);
                    $teamResult->setTeam($team);
                    $teamResult->setGameResult(2);
                }
                $this->em->persist($teamResult);
                $this->em->flush();
            }
        }

    }
}
