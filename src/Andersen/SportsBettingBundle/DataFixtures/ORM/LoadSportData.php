<?php
namespace Andersen\SportsBettingBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Andersen\SportsBettingBundle\Entity\Sport;

class LoadSportData implements FixtureInterface
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
        foreach ($sports as &$value){
            $sportType = new Sport();
            $sportType->setSportType($value);

            $manager->persist($sportType);
            $manager->flush();
        }

    }
}
