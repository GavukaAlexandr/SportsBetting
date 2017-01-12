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
        $teams = $manager->getRepository('SportsBettingBundle:Team')->findAll();
        $count = count($teams);
        $countFor = $count / 2;
        $countFor = floor($countFor);
        $games = [];

        for ($i = 1; $i <= $countFor; $i++){
            $games[$i] = $teams[rand(0, $count-1)]->getName(). " - " . $teams[rand(0, $count-1)]->getName();
        }

        foreach ($games as $key => $name)
        {
            $gameType = new Game();
            $gameType->setName($name);
//            $gameType->setTeamWinner('');
            $gameType->setSport($this->getReference("sport-team {$key}"));

            $manager->persist($gameType);
            $manager->flush();
        }
    }

    public function getOrder()
    {
        return 2;
        // TODO: Implement getOrder() method.
    }
}
