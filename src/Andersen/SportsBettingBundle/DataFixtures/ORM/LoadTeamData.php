<?php
namespace Andersen\SportsBettingBundle\DataFixtures\ORM;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Andersen\SportsBettingBundle\Entity\Team;

class LoadTeamData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $teamNames = [
            'Anaheim Ducks',
            'Arizona Cardinals',
            'Arizona Coyotes',
            'Arizona Diamondbacks',
            'Atlanta Braves',
            'Atlanta Falcons',
            'Atlanta Hawks',
            'Atlanta United FC',
            'Baltimore Orioles',
            'Baltimore Ravens',
            'BC Lions',
            'Boston Bruins',
            'Boston Celtics',
            'Boston Red Sox',
            'Brooklyn Nets',
            'Buffalo Bills',
            'Buffalo Sabres',
            'Calgary Flames',
            'Calgary Stampeders',
            'Carolina Hurricanes',
            'Carolina Panthers',
            'Charlotte Hornets',
            'Chicago Bears',
            'Chicago Blackhawks',
            'Chicago Bulls',
            'Chicago Cubs',
            'Chicago Fire',
            'Chicago White Sox',
            'Cincinnati Bengals',
            'Cincinnati Reds',
            'Cleveland Browns',
            'Cleveland Cavaliers',
            'Cleveland Indians',
            'Colorado Avalanche',
            'Colorado Rapids',
            'Colorado Rockies',
            'Columbus Blue Jackets',
            'Columbus Crew SC',
            'FC Dallas',
            'Dallas Mavericks',
            'Dallas Stars',
            'D.C. United',
            'Denver Broncos',
            'Denver Nuggets',
            'Detroit Lions',
            'Detroit Pistons',
            'Detroit Red Wings',
            'Detroit Tigers',
            'Edmonton Eskimos',
            'Edmonton Oilers',
            'Florida Panthers',
            'Golden State Warriors',
            'Green Bay Packers',
            'Hamilton Tiger-Cats',
            'Houston Astros',
            'Houston Dynamo',
            'Houston Rockets',
            'Houston Texans',
            'Indiana Pacers',
            'Indianapolis Colts',
            'Jacksonville Jaguars',
            'Sporting Kansas City',
            'Kansas City Chiefs',
            'Kansas City Royals',
            'LA Galaxy',
            'Los Angeles Angels of Anaheim',
            'Los Angeles Kings',
            'Memphis Grizzlies',
            'Miami Dolphins',
            'Miami Heat',
            'Miami Marlins',
            'Milwaukee Brewers',
            'Milwaukee Bucks',
            'Minnesota Twins',
            'Minnesota United FC',
            'San Francisco Giants',
            'San Jose Earthquakes',
            'San Jose Sharks',
            'Saskatchewan Roughriders',
            'St. Louis Blues',
        ];
//todo зробити цикл який буде розприділяти по ~5 команд на гру;
        $referenceId = 0;
        $sportId = $this->getReference("sport-team {$referenceId}");

        foreach ($teamNames as $index => $team) {
            if (!(++$index % 5)) {
                $referenceId++;
                $sportId = $sportId = $this->getReference("sport-team {$referenceId}");
            }

//            echo "<pre>" . var_dump($team) . "</pre>";
            $teamType = new Team();
            $teamType->setName($team);
            $teamType->setSport($sportId);
            $manager->persist($teamType);
        }

        $manager->flush();
    }

    public
    function getOrder()
    {
        return 1;
        // TODO: Implement getOrder() method.
    }
}
