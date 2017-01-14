<?php

namespace Andersen\SportsBettingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Game
 *
 * @ORM\Table(name="game")
 * @ORM\Entity(repositoryClass="Andersen\SportsBettingBundle\Repository\GameRepository")
 */
class Game implements \JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * Many Games have Many Teams
     * @ORM\ManyToMany(targetEntity="Andersen\SportsBettingBundle\Entity\Team", mappedBy="games")
     */
    private $teams;

    /**
     * @var string
     *
     * @ORM\Column(name="teamWinner", type="string", length=255, nullable=true)
     */
    private $teamWinner;

    /**
     * Many Game have one Sport
     * @ORM\ManyToOne(targetEntity="Andersen\SportsBettingBundle\Entity\Sport", inversedBy="games")
     */
    private $sport;

    /**
     * One Game has many Bets.
     * @ORM\OneToMany(targetEntity="Andersen\SportsBettingBundle\Entity\Bet", mappedBy="game")
     */
    protected $bets;

    /**
     * @return mixed
     */
    public function getSport()
    {
        return $this->sport;
    }

    /**
     * @param mixed $sport
     */
    public function setSport($sport)
    {
        $this->sport = $sport;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Game
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set teams
     *
     * @param string $teams
     *
     * @return Game
     */
    public function setTeams($teams)
    {
        $this->teams = $teams;

        return $this;
    }

    /**
     * Get teams
     *
     * @return string
     */
    public function getTeams()
    {
        return $this->teams;
    }

    /**
     * Set teamWinner
     *
     * @param string $teamWinner
     *
     * @return Game
     */
    public function setTeamWinner($teamWinner)
    {
        $this->teamWinner = $teamWinner;

        return $this;
    }

    /**
     * Get teamWinner
     *
     * @return string
     */
    public function getTeamWinner()
    {
        return $this->teamWinner;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->teams = new \Doctrine\Common\Collections\ArrayCollection();
        $this->bets = new \Doctrine\Common\Collections\ArrayCollection();

    }

    /**
     * Add team
     *
     * @param \Andersen\SportsBettingBundle\Entity\Team $team
     *
     * @return Game
     */
    public function addTeam(\Andersen\SportsBettingBundle\Entity\Team $team)
    {
        if (!$this->teams->contains($team))
        {
            $this->teams[] = $team;
            $team->addGame($this);
        }

        return $this;
    }

    /**
     * Remove team
     *
     * @param \Andersen\SportsBettingBundle\Entity\Team $team
     */
    public function removeTeam(\Andersen\SportsBettingBundle\Entity\Team $team)
    {
        $this->teams->removeElement($team);
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        return [
            'name' => $this->getName(),
//            'teams' => $this->getTeams(),
//            'teamWinner' => $this->getTeamWinner(),
//            'sport' => $this->getSport()
        ];
        // TODO: Implement jsonSerialize() method.
    }

    /**
     * Add bet
     *
     * @param \Andersen\SportsBettingBundle\Entity\Bet $bet
     *
     * @return Game
     */
    public function addBet(\Andersen\SportsBettingBundle\Entity\Bet $bet)
    {
        $this->bets[] = $bet;

        return $this;
    }

    /**
     * Remove bet
     *
     * @param \Andersen\SportsBettingBundle\Entity\Bet $bet
     */
    public function removeBet(\Andersen\SportsBettingBundle\Entity\Bet $bet)
    {
        $this->bets->removeElement($bet);
    }

    /**
     * Get bets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBets()
    {
        return $this->bets;
    }
}
