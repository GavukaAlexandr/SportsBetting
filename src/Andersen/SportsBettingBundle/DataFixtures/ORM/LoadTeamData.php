<?php
namespace Andersen\SportsBettingBundle\DataFixtures\ORM;

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

        $key2 = 0;

        foreach ($teamName as $key => $value)
        {

            if ($key > 4)
            {
                $key2 = $key - rand(1, 3);
            }

            $teamType = new Team();
            $teamType->setName($value);
            $teamType->setSport($this->getReference("sport-team {$key2}"));

            $this->setReference("teams-games {$key}", $teamType);
            $this->setReference("team-bets {$key}", $teamType);
            
            $manager->persist($teamType);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
        // TODO: Implement getOrder() method.
    }
}
