<?php
namespace Andersen\SportsBettingBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Andersen\SportsBettingBundle\Entity\Sport;

class LoadSportData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        //написати масив із видами спорту і форіч який буде записувати ці фікстури в базу
        //https://www.sitepoint.com/data-fixtures-symfony2/

        $sports = [
            "Auto racing",
            "Motorcycle racing",
            "Truck racing",
            "Ice climbing",
            "Mountaineering",
            "Rallying",
            "Surfing",
            "Basketball",
            "Football",
            "Baseball",
            "Hockey",
            "Sprint",
            "Roller",
            "Canadian football",
            "American football",
            "Freestyle",
            "Coding",
        ];
        foreach ($sports as $key => $value){
            $sportType = new Sport();
            $sportType->setSportType($value);

            $this->setReference("sport-team {$key}", $sportType);
            $this->setReference("sport-bets {$key}", $sportType);

            $manager->persist($sportType);
        }
        $manager->flush();

    }

    public function getOrder()
    {
        return 0;
        // TODO: Implement getOrder() method.
    }
}
