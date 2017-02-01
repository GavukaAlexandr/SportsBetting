<?php

namespace Andersen\SportsBettingBundle\Command;

use Andersen\SportsBettingBundle\Entity\Game;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;


class CreateTimeForGameCommand extends Command
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
            ->setName('Sport:create-time-for-game')
            // the short description shown while running "php bin/console list"
            ->setDescription('Create Time For Game.')
            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp("This command Create Time For Game");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //вибірка всих ігор без часу
        $gamesWithoutTime = $this->em->getRepository('SportsBettingBundle:Game')->findGamesWithoutTime();

        $teamsFromGame = [];
        //вибірка команд в іграх

        /** @var Game $game */
        foreach ($gamesWithoutTime as $key => $game) {
            $teams = $this->em->getRepository('SportsBettingBundle:Team')->findTeamsInGame($game->getId());

            //формування масиву з валідними іграми і командами
            if (empty($teams) || count($teams) < 2) {
                $output->writeln('Game: ' . $game->getName() . '. Game has a < 2 teams');
            } else {
                //створити форіч який буде вибирати всі не завершені ігри з даною командою і поміщатиме час всих ігор у масив
                $timeGames = [];

                foreach ($teams as $team) {
                    $gamesNotComplite = $this->em->getRepository('SportsBettingBundle:Game')->selectGamesWherePlayTeamFromOurGame($team->getId());
                    foreach ($gamesNotComplite as $item) {
                    $timeGames[] = $item->getFinishTime();

                    }
                }

                $maxTime = max($timeGames);
                $startTime = null;
                $finishTime = null;

                if ($maxTime == null) {
                    $startTime = new \DateTime('now');
                    $startTime->add(new \DateInterval('PT1M'));
                    $finishTime = clone $startTime;
                    $finishTime->add(new \DateInterval('PT1M'));
                } else {
                    $startTime = $maxTime->add(new \DateInterval('PT1M'));
                    $finishTime = clone $startTime;
                    $finishTime = $startTime->add(new \DateInterval('PT1M'));
                }

                $game->setStartTime($startTime);
                $game->setFinishTime($finishTime);
                $this->em->persist($game);
                $this->em->flush();
            }
        }
        }
}
