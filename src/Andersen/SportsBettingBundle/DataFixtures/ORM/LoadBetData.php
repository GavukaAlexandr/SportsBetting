<?php
//namespace Andersen\SportsBettingBundle\DataFixtures\ORM;
//
//use Doctrine\Common\DataFixtures\AbstractFixture;
//use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
//use Doctrine\Common\DataFixtures\FixtureInterface;
//use Doctrine\Common\Persistence\ObjectManager;
//use Andersen\SportsBettingBundle\Entity\Bet;
//
//class LoadBetData extends AbstractFixture implements OrderedFixtureInterface
//{
//    public function load(ObjectManager $manager)
//    {
//        $betsValue=[];
//        for($i = 0; $i <= 16; $i++)
//        {
//            $betsValue[] = rand(50, 1000);
//        }
//
//        foreach ($betsValue as $value)
//        {
//            $betType = new Bet();
//            $betType->setBetsValue($value);
////            $this->addReference('Sport', $betType);
//
//            $manager->persist($betType);
//            $manager->flush();
//        }
//
//    }
//
//    public function getOrder()
//    {
//        // TODO: Implement getOrder() method.
//    }
//}
