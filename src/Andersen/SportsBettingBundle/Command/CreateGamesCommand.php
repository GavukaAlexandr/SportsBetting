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
        // Get argument Of CLI
        $numberGames = intval($input->getArgument('numberGames'));
        $numberSports = intval($input->getArgument('numberSports'));

        // send message in CLI
        $output->writeln('now will create ' . $numberGames . ' games for you ' . $numberSports . ' sports type');

        // get all sports
        $sports = $this->em->getRepository('SportsBettingBundle:Sport')->findAll();
        $countSports = count($sports);

        // Create sports array
        $sportsArray = [];
        for ($i = 0; $i < $numberSports; $i++)
        {
            $sportsArray[] = $sports[rand(0, $countSports)];
        }

        // Create Games for sport types
        foreach ($sportsArray as $sport) {

            // get team by Id
            $teams = $this->em->getRepository('SportsBettingBundle:Team')->findGamesOfSportType($sport->getId());

            //Count teams
            $countTeams = count($teams) - 1;

            // Create number of games
            // Number games = CLI parametrs $numberGames
            for ($a = 1; $a < $numberGames; $a++)
            {
                // Generate random Game name
                $nameObj1 = $teams[rand(0, $countTeams)];
                $nameObj2 = $teams[rand(0, $countTeams)];
                // Get name Of object
                $name1 = $nameObj1->getName();
                $name2 = $nameObj2->getName();

                //checking the uniqueness of the teams in the game
                for ($n = $name1; $n == $name2;)
                {
                    $nameObj2 = $teams[rand(1, $countTeams)];
                    $name2 = $nameObj2->getName();
                }

                $name = $name1 . " - " . $name2;

                //Write generated game in db
                $gameType = new Game();
                $gameType->setName($name);
                $gameType->setSport($sport);
                $gameType->addTeams([$nameObj1, $nameObj2]);

                $this->em->persist($gameType);
                $this->em->flush();
            }
        }
    }
}
