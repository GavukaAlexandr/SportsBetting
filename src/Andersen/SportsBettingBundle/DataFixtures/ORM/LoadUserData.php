<?php
namespace Andersen\SportsBettingBundle\DataFixtures\ORM;

use Andersen\SportsBettingBundle\Entity\Sport;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Andersen\SportsBettingBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $userMoney = rand(100, 999999);
        $usersName = [
            'Aleksandr', 'Aleksey', 'Boris', 'Vadim', 'Valentin', 'Valeriy', 'Vladimir',
            'Vladislav', 'Gennady', 'Georgy', 'Gleb', 'Igor', 'Iosif', 'Kirill', 'Lev',
            'Leonid', 'Maxim', 'Nikita', 'Nikolay', 'Oleg',
        ];
        $countUsers = count($usersName);

        $date = new \DateTime();


//                var_dump($date); exit();


        for ($i=1; $i<=333; $i++)
        {
            $getName = $usersName[rand(0, $countUsers-1)];
            $getEmail = $getName . '@' . 'mail.com';

            $userType = new User();
            $userType->setName($getName);
            $userType->setUsername("user{$i}");
            $userType->setUsernameCanonical("user{$i}");
            $userType->setEnabled(TRUE);
            $userType->setLastLogin($date);
            $userType->setRoles(['ROLE_USER']);
            $userType->setMoney($userMoney);
            $userType->setEmail($getEmail.$i);
            $userType->setEmailCanonical($getEmail.$i);
            $userType->setPassword('$2y$13$g45IbFPv1AMiY4MSCiBIeeGQ4QFyd/1zfloDTrjWJo3MUDW47o8oO');

            $this->setReference("user-bets {$i}", $userType);

            $manager->persist($userType);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
        // TODO: Implement getOrder() method.
    }
}
