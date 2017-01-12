<?php
namespace Andersen\SportsBettingBundle\DataFixtures\ORM;

use Andersen\SportsBettingBundle\Entity\Team;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Andersen\SportsBettingBundle\Entity\Game;

class LoadGameData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $sports = $manager->getRepository('SportsBettingBundle:Sport')->findAll();
        $countSports = count($sports);
        $teams = $manager->getRepository('SportsBettingBundle:Team')->findAll();
        $countTeams = count($teams);
        $countFor = 150;
        $games = [];


        for ($i = 1; $i <= $countFor; $i++){
            $games[$i] = $teams[rand(0, $countTeams-1)]->getName(). " - " . $teams[rand(0, $countTeams-1)]->getName();
        }

//        var_dump($games); exit();

        foreach ($games as $key => $name)
        {
            $key2 = rand(1, $countSports-1);

            $gameType = new Game();
            $gameType->setName($name);
//            $gameType->setTeamWinner('');
            $gameType->setSport($this->getReference("sport-team {$key2}"));

            $this->setReference("games-bets {$key}", $gameType);
//var_dump($key);
            $manager->persist($gameType);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
        // TODO: Implement getOrder() method.
    }
}
