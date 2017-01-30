<?php

namespace Andersen\SportsBettingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


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
     * One Game have many TeamResults
     *
     * @ORM\OneToMany(targetEntity="Andersen\SportsBettingBundle\Entity\TeamResult", mappedBy="Game")
     */
    private $teamResult;

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
    private $bets;

    /**
     * @var $coefficients[]
     *
     * One Game have Many Coefficients
     * @ORM\OneToMany(targetEntity="Andersen\SportsBettingBundle\Entity\Coefficient", mappedBy="game")
     */
    private $coefficients;

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
        $this->teams = new ArrayCollection();
        $this->bets = new ArrayCollection();
        $this->coefficients = new ArrayCollection();
        $this->teamResult = new ArrayCollection();

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
     * @param array Team[] $teams
     */
    public function addTeams(array $teams)
    {
        foreach ($teams as $team){
           $this->addTeam($team);
        }
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

    /**
     * Add coefficient
     *
     * @param \Andersen\SportsBettingBundle\Entity\Coefficient $coefficient
     *
     * @return Game
     */
    public function addCoefficient(\Andersen\SportsBettingBundle\Entity\Coefficient $coefficient)
    {
        $this->coefficients[] = $coefficient;

        return $this;
    }

    /**
     * Remove coefficient
     *
     * @param \Andersen\SportsBettingBundle\Entity\Coefficient $coefficient
     */
    public function removeCoefficient(\Andersen\SportsBettingBundle\Entity\Coefficient $coefficient)
    {
        $this->coefficients->removeElement($coefficient);
    }

    /**
     * Get coefficients
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCoefficients()
    {
        return $this->coefficients;
    }

    /**
     * Get teams
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTeams()
    {
        return $this->teams;
    }

    /**
     * Add teamResult
     *
     * @param \Andersen\SportsBettingBundle\Entity\TeamResult $teamResult
     *
     * @return Game
     */
    public function addTeamResult(\Andersen\SportsBettingBundle\Entity\TeamResult $teamResult)
    {
        $this->teamResult[] = $teamResult;

        return $this;
    }

    /**
     * Remove teamResult
     *
     * @param \Andersen\SportsBettingBundle\Entity\TeamResult $teamResult
     */
    public function removeTeamResult(\Andersen\SportsBettingBundle\Entity\TeamResult $teamResult)
    {
        $this->teamResult->removeElement($teamResult);
    }

    /**
     * Get teamResult
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTeamResult()
    {
        return $this->teamResult;
    }
}
