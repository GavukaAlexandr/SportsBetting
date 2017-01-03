<?php
namespace Andersen\SportsBettingBundle\DataFixtures\ORM;

use Andersen\SportsBettingBundle\Entity\Sport;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Andersen\SportsBettingBundle\Entity\User;

class LoadUserDataData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $userMoney = [
            ["User 1", "1"],
            ["User 2", "2"],
            ["User 3", "3"],
            ["User 4", "4"],
            ["User 5", "5"],
            ["User 6", "6"],
            ["User 7", "7"],
            ["User 8", "8"],
            ["User 9", "9"],
            ["User 10", "10"],
        ];

        foreach ($userMoney as list($users, $moneys))
        {
            $userType = new User();
            $userType->setName($users);
            $userType->setMoney($moneys);

            $manager->persist($userType);
            $manager->flush();
        }
    }

    public function getOrder()
    {
        // TODO: Implement getOrder() method.
    }
}
