<?php

namespace Andersen\SportsBettingBundle\Command;

use Andersen\SportsBettingBundle\Entity\Game;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;


class CreateGamesCommand extends Command
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
            ->setName('Sport:create-games')
            // the short description shown while running "php bin/console list"
            ->setDescription('Creates new games.')
            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp("This command allows you to create games...")
            ->addArgument('numberGames', InputArgument::REQUIRED, 'how many games do you want?')
            ->addArgument('numberSports', InputArgument::REQUIRED, 'how many sports type do you want? "1-17"')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $numberGames = intval($input->getArgument('numberGames'));
        $numberSports = intval($input->getArgument('numberSports'));
        $output->writeln('Yes my Lord, now will create ' . $numberGames . ' games for you ' . $numberSports . ' sports type');

        $sports = $this->em->getRepository('SportsBettingBundle:Sport')->findAll();
        $countSports = count($sports);

        $sportsArray = [];
        for ($i = 1; $i < $numberSports; $i++)
        {
            $sportsArray[] = $sports[rand(1, $countSports)];
        }

        foreach ($sportsArray as $sport) {

            $teams = $this->em->getRepository('SportsBettingBundle:Team')->findGamesOfSportType($sport['id']);
            $countTeams = count($teams);

            for ($i = 1; $i < $numberGames; $i++)
            {
                $name1 = $teams[rand(0, $countTeams)];
                $name2 = $teams[rand(0, $countTeams)];

                for ($i = $name1; $i == $name2;)
                {
                 $name2 = $teams[rand(1, $countTeams)];
                }

                $name = $name1 . " " . $name2;

                $gameType = new Game();
                $gameType->setName($name);
                $gameType->setSport($sport);

                $this->em->persist($gameType);
                $this->em->flush();
            }
        }
    }
}
