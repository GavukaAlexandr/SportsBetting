<?php

namespace Andersen\SportsBettingBundle\Command;

use Andersen\SportsBettingBundle\Entity\Coefficient;
use Andersen\SportsBettingBundle\Entity\Game;
use Andersen\SportsBettingBundle\Entity\Team;
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
        $numberSports = $numberSports - 1;

        // send message in CLI
        $output->writeln('now will create ' . $numberGames . ' games for you ' . $numberSports . ' sports type');

        // get all sports
        $sports = $this->em->getRepository('SportsBettingBundle:Sport')->findAll();
        $countSports = count($sports) - 1;

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
                /** @var Team $nameObj1 */
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

                $this->createCoefficient($nameObj1, $nameObj2, $gameType);

                $this->em->flush();
            }
        }
    }

    protected function createCoefficient($nameObj1, $nameObj2, $game)
    {
        /** Find games where teams played */
        $gamesWhereTeam1Played = count($this->em->getRepository('SportsBettingBundle:Game')->findGamesWhereTeamPlayed($nameObj1->getId()));
        if ($gamesWhereTeam1Played == 0) {
            $gamesWhereTeam1Played = 50;
        }
        $gamesWhereTeam2Played = count($this->em->getRepository('SportsBettingBundle:Game')->findGamesWhereTeamPlayed($nameObj2->getId()));
        if ($gamesWhereTeam2Played == 0) {
            $gamesWhereTeam2Played = 50;
        }
        /** Find games where teams won */
        $gamesWhereTeam1Won = count($this->em->getRepository('SportsBettingBundle:Game')->findGamesWithParameters($nameObj1->getId(), 1));
        if ($gamesWhereTeam1Won == 0) {
            $gamesWhereTeam1Won = 40;
        }
        $gamesWhereTeam2Won = count($this->em->getRepository('SportsBettingBundle:Game')->findGamesWithParameters($nameObj2->getId(), 1));
        if ($gamesWhereTeam2Won == 0) {
            $gamesWhereTeam2Won = 40;
        }
        /** Find games where teams Draw */
        $gamesWhereTeam1Draw = count($this->em->getRepository('SportsBettingBundle:Game')->findGamesWithParameters($nameObj1->getId(), 0));
        if ($gamesWhereTeam1Draw == 0) {
            $gamesWhereTeam1Draw = 5;
        }
        $gamesWhereTeam2Draw = count($this->em->getRepository('SportsBettingBundle:Game')->findGamesWithParameters($nameObj2->getId(), 0));
        if ($gamesWhereTeam2Draw == 0) {
            $gamesWhereTeam2Draw = 5;
        }

        /** the percentage of success of the team */
        $team1Success = $gamesWhereTeam1Won / $gamesWhereTeam1Played;
        $team2Success = $gamesWhereTeam2Won / $gamesWhereTeam2Played;

        /** the probability of a draw */
        $draw = $gamesWhereTeam1Draw + $gamesWhereTeam2Draw / $gamesWhereTeam2Draw;

        /** probability events */
        $probabilityEvents = 1 / 3;

        /** the total probability of each event */
        $totalProbabilityEachEvent = ($probabilityEvents * $team1Success) + ($probabilityEvents * $team2Success) + ($probabilityEvents * $draw);

        /** the percent of winning */
        $percentWinningTeam1 = $probabilityEvents * $team1Success / $totalProbabilityEachEvent;
        $percentWinningTeam2 = $probabilityEvents * $team2Success / $totalProbabilityEachEvent;
        $percentWinningDraw = $probabilityEvents * $draw / $totalProbabilityEachEvent;

        /** Coefficients */
        $team1 = 1 / $percentWinningTeam1;
        $team2 = 1 / $percentWinningTeam2;
        $draw = 1 / $percentWinningDraw;

        /** Round coefficient */
        $draw = round($draw, 2);
        $team1 = round($team1, 2);
        $team2 = round($team2, 2);

        $coefficient = new Coefficient();
        $coefficient->setTeam($nameObj1);
        $coefficient->setGame($game);
        $coefficient->setTypeCoefficient(0);
        $coefficient->setValue($draw);
        $this->em->persist($coefficient);
        $this->em->flush();

        $coefficient = new Coefficient();
        $coefficient->setTeam($nameObj1);
        $coefficient->setGame($game);
        $coefficient->setTypeCoefficient(1);
        $coefficient->setValue($team1);
        $this->em->persist($coefficient);
        $this->em->flush();

        $coefficient = new Coefficient();
        $coefficient->setTeam($nameObj2);
        $coefficient->setGame($game);
        $coefficient->setTypeCoefficient(1);
        $coefficient->setValue($team2);
        $this->em->persist($coefficient);
        $this->em->flush();
    }

    /**
     * =====Формула Байеса======
     *
     * =======ЛЕГЕНДА============
     */
//          А – состоялся матч (событие);
//  Н1 – гипотеза, что победит (первая - 1) команда;
//  Н2 – гипотеза, что победит (вторая - 2) команда;
//  Н3 – гипотеза, что будет ничья;
//  Р(А) – повна ймовірність того що подія відбудеться
    /**
     * Р(Н1)=Р(Н2)=Р(Н3)=1/3, то есть это одинаковая вероятность событий (победа 1, победа 2, ничья);
     *
     * ймовірність виграшу кожної з команд і нічия
     * РН1(А) команда 1 = 50 побед / загальну кількість зіграних ігор
     * РН2(А) команда 2 = 70 побед  / загальну кількість зіграних ігор
     * РН3(А) нічія = нічія 1 команди + нічія 2 команди / на загальну кількість ігор однієї з команд
     *
     * знайдемо Р(А):
     * Р(А) = Р(Н1)*РН1(А)+ Р(Н2)*РН2(А)+ Р(Н3)*РН3(А) //повна ймовірність настання одної з подій
     *
     * Тепер можна знайти Ра(Н1-2-3):
     * Ра(Н1) =Р(Н1)*РН1(А) / Р(А) //шанс виграшу першої команди
     * Ра(Н2) =Р(Н2)*РН2(А) / Р(А) //шанс виграшу другої команди
     * Ра(Н3) =Р(Н3)*РН3(А) / Р(А) //шанс виграшу третьої команди
     *
     *
     */
}
