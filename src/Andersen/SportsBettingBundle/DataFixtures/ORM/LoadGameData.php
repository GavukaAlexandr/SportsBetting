<?php
namespace Andersen\SportsBettingBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Andersen\SportsBettingBundle\Entity\Game;

class LoadGameData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $game = [
            ["Game 1", "Team 1"],
            ["Game 2", "Team 2"],
            ["Game 3", "Team 3"],
            ["Game 4", "Team 4"],
            ["Game 5", "Team 5"],
            ["Game 6", "Team 6"],
            ["Game 7", "Team 7"],
            ["Game 8", "Team 8"],
            ["Game 9", "Team 9"],
            ["Game 10", "Team 10"],
        ];

        foreach ($game as list($games, $teams))
        {
            $gameType = new Game();
            $gameType->setName($games);
            $gameType->setTeamWinner($teams);
            $manager->persist($gameType);
            $manager->flush();
        }
    }

    public function getOrder()
    {
        // TODO: Implement getOrder() method.
    }
}
