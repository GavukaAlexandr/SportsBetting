<?php
namespace Andersen\SportsBettingBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Andersen\SportsBettingBundle\Entity\Bet;

class LoadBetData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $sports = $manager->getRepository('SportsBettingBundle:Sport')->findAll();
        $teams = $manager->getRepository('SportsBettingBundle:Team')->findAll();
        $games = $manager->getRepository('SportsBettingBundle:Game')->findAll();
        $users = $manager->getRepository('SportsBettingBundle:User')->findAll();



        for ($i = 1; $i <=10000; $i++)
        {
            $countSports = rand(1, count($sports)-2);
            $countTeams = rand(1, count($teams)-2);
            $countGames = rand(1, count($games)-2);
            $countUsers = rand(1, count($users)-2);

            $betType = new Bet();
            $betType->setSport($this->getReference("sport-bets {$countSports}"));
            $betType->setTeam($this->getReference("team-bets {$countTeams}"));
            $betType->setGame($this->getReference("games-bets {$countGames}"));
            $betType->setUser($this->getReference("user-bets {$countUsers}"));

            $betType->setBetsValue(rand(1, 3));
            $betType->setFactorVictory(rand(1,10));
            $betType->setFactorDraw(rand(1, 10));
            $betType->setMoney(rand(1, 999));

            $manager->persist($betType);
        }
        $manager->flush();

    }

    public function getOrder()
    {
        return 4;
        // TODO: Implement getOrder() method.
    }
}
