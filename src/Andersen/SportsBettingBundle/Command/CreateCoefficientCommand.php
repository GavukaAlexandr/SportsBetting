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


class CreateCoefficientCommand extends Command
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
            ->setName('Sport:create-coefficient')
            // the short description shown while running "php bin/console list"
            ->setDescription('Creates coefficient.')
            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp("This command allows you to create coefficient...")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //choose games without coefficients
        $gamesWithoutCoefficients = $this->em->getRepository('SportsBettingBundle:Game')->FindGamesWithoutCoefficients();

        foreach ($gamesWithoutCoefficients as $gamesWithoutCoefficient)
        {
            //find teams in game
            $teamsInGame = $this->em->getRepository('SportsBettingBundle:Team')->findTeamsInGame($gamesWithoutCoefficient->getId());

            $teamSuccess = [];

            foreach ($teamsInGame as $teamInGame){
                //Find games where team played
                $gamesWhereTeamPlayed = $this->em->getRepository('SportsBettingBundle:Game')->findGamesWhereTeamPlayed($teamInGame->getId());

                //Find games where team won
                $gamesWhereTeamWon = $this->em->getRepository('SportsBettingBundle:Game')->findGamesWithParameters($teamInGame->getId(), 1);

                //Find games where team lost
                $gamesWhereTeamLost = $this->em->getRepository('SportsBettingBundle:Game')->findGamesWithParameters($teamInGame->getId(), 2);

                //Find games where team Draw
                $gamesWhereTeamDraw = $this->em->getRepository('SportsBettingBundle:Game')->findGamesWithParameters($teamInGame->getId(), 0);

//                $teamSuccess[$teamInGame->getName()] = $gamesWhereTeamWon->get / ($gamesWhereTeamWon + $gamesWhereTeamLost + $gamesWhereTeamDraw); //50/(10+5+50)
                return $gamesWhereTeamWon;
            }

//            count($teamSuccess);

        }

        //---Вибрати всі ігри у яких немає коефіцієнтів
        //---сформувати із них масив ігор
        //---форіч перебираючи масив ігор
            //---вибірка з бази всіх команд які беруть участь у грі в масив
            //---форіч команди по одній із масиву
                //---вибірка всих ігор в яких грала команда
                //---вибірка всих ігор в яких команда виграла
                //---вибірка всих ігор в яких команда програла
                //---вибірка вих ігор які закінчилися нічиєю

                //вирахування успішності команди - a
                //додати результати в масив під назвою Team[1] (Team[2] - [0])


    }
}


/**
 * =====Формула Байеса======
 *
 * =======ЛЕГЕНДА============
 ***А – состоялся матч (событие);
Н1 – гипотеза, что победит (первая - 1) команда;
Н2 – гипотеза, что победит (вторая - 2) команда;
Н3 – гипотеза, что будет ничья;
Р(А) – повна ймовірність того що подія відбудеться
 *
 *
 *
Р(Н1)=Р(Н2)=Р(Н3)=1/3, то есть это одинаковая вероятность событий (победа 1, победа 2, ничья);
 *
 *
 *
 * ймовірність виграшу кожної з команд і нічия
РН1(А) команда 1 = 50 побед / загальну кількість зіграних ігор
РН2(А) команда 2 = 70 побед  / загальну кількість зіграних ігор
РН3(А) нічія = нічія 1 команди + нічія 2 команди / на загальну кількість ігор однієї з команд
 *
 *
 *
знайдемо Р(А):
Р(А) = Р(Н1)*РН1(А)+ Р(Н2)*РН2(А)+ Р(Н3)*РН3(А) //повна ймовірність настання одної з подій
 *
 *
 *
Тепер можна знайти Ра(Н1-2-3):
Ра(Н1) =Р(Н1)*РН1(А) / Р(А) //шанс виграшу першої команди
Ра(Н2) =Р(Н2)*РН2(А) / Р(А) //шанс виграшу другої команди
Ра(Н3) =Р(Н3)*РН3(А) / Р(А) //шанс виграшу третьої команди
 *
 *
 */
