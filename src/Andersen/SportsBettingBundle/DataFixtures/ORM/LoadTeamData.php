<?php
namespace Andersen\SportsBettingBundle\DataFixtures\ORM;

use Andersen\SportsBettingBundle\Entity\Sport;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Andersen\SportsBettingBundle\Entity\Team;

class LoadTeamData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $teamName = [
            "Anaheim Ducks",
            "Arizona Cardinals",
            "Atlanta Falcons",
            "Baltimore Orioles",
            "BC Lions",
            "Boston Bruins",
            "Boston Celtics",
            "Brooklyn Nets",
            "Buffalo Bills",
            "Calgary Flames",
            "Carolina Hurricanes",
            "Charlotte Hornets",
            "Chicago Bears",
            "Cincinnati Bengals",
            "Cleveland Browns",
            "Colorado Avalanche",
            "D.C. United",
        ];

        foreach ($teamName as &$value)
        {
            $teamType = new Team();
            $teamType->setName($value);
//            $teamType->setSport($this->addReference('sport', Sport));
//            $this->addReference('sport', $teamType);

            $manager->persist($teamType);
            $manager->flush();
        }
    }

    public function getOrder()
    {
        // TODO: Implement getOrder() method.
    }
}
