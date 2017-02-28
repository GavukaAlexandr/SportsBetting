<?php

namespace Andersen\SportsBettingBundle\Command;

use Andersen\SportsBettingBundle\Entity\Bet;
use Andersen\SportsBettingBundle\Entity\Coefficient;
use Andersen\SportsBettingBundle\Entity\Game;
use Andersen\SportsBettingBundle\Entity\Team;
use Andersen\SportsBettingBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;


class CreateBetsCommand extends Command
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
            ->setName('Sport:create-bets')
            // the short description shown while running "php bin/console list"
            ->setDescription('Creates new bets.')
            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp("This command allows you to create bets")
            ->addArgument('numberBets', InputArgument::REQUIRED, 'how many games do you want?')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** Get argument Of CLI */
        $numberBets = intval($input->getArgument('numberBets'));

        /** send message in CLI */
        $output->writeln('now will create ' . $numberBets . ' bets');

        /** select  not complete game */
        $notCompleteGame = $this->em->getRepository('SportsBettingBundle:Game')->notCompleteGame();

        /** select user by id = 1*/
        /** @var User $user */
        $user = $this->em->getRepository('SportsBettingBundle:User')->findUserById(1);

        /** count $notCompleteGame */
        $countNotCompleteGame = count($notCompleteGame);

        $games = [];

        for ($i = 0; $i < $numberBets; $i++)
        {
            $games[] = $notCompleteGame[rand(0, $countNotCompleteGame)];
        }

        /** @var Game $game */
        foreach ($games as $game) {
            /** @var Team $teamsInGame */
            $teamsInGame = $this->em->getRepository('SportsBettingBundle:Team')->findTeamsInGame($game->getId());
            /** @var Team $randTeamNumber */
            $randTeamNumber = array_rand($teamsInGame);
            /** @var Team $randTeam */
            $randTeam = $teamsInGame[$randTeamNumber];

            /** @var Coefficient $teamCoefficient */
            $teamCoefficient = $this->em->getRepository('SportsBettingBundle:Coefficient')->selectTeamCoefficientByGameId($game->getId(), $randTeam->getId());


//            $randBet = rand(0, 1);//todo заменить на ентити коефициент
            $randMoney = rand(1, 999);

            $bet = new Bet();
            $bet->setTeam($randTeam);
            $bet->setGame($game);
            $bet->setUser($user[0]);
            $bet->setCoefficient($teamCoefficient);
            $bet->setMoney($randMoney);
            $this->em->persist($bet);
            $this->em->flush();
        }

    }
}
