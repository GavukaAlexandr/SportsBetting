<?php

namespace Andersen\SportsBettingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Team
 *
 * @ORM\Table(name="team")
 * @ORM\Entity(repositoryClass="Andersen\SportsBettingBundle\Repository\TeamRepository")
 */
class Team implements \JsonSerializable
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
     * Many Team have One Sport
     * @ORM\ManyToOne(targetEntity="Andersen\SportsBettingBundle\Entity\Sport", inversedBy="teams")
     */
    private $sport;

    /**
     * Many Teams have Many Games
     * @ORM\ManyToMany(targetEntity="Andersen\SportsBettingBundle\Entity\Game", inversedBy="teams")
     */
    private $games;

    /**
     * One Team has many Bets.
     * @ORM\OneToMany(targetEntity="Andersen\SportsBettingBundle\Entity\Bet", mappedBy="team")
     */
    protected $bets;

    /**
     * @var $coefficients[]
     *
     * One Team have Many Coefficients
     * @ORM\OneToMany(targetEntity="Andersen\SportsBettingBundle\Entity\Coefficient", mappedBy="team")
     */
    private $coefficients;

    /**
     * One Team have Many TeamResults
     *
     * @ORM\OneToMany(targetEntity="Andersen\SportsBettingBundle\Entity\TeamResult", mappedBy="team")
     */
    private $teamResult;


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
     * @return Team
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
     * Set sport
     *
     * @param string $sport
     *
     * @return Team
     */
    public function setSport($sport)
    {
        $this->sport = $sport;

        return $this;
    }

    /**
     * Get sport
     *
     * @return string
     */
    public function getSport()
    {
        return $this->sport;
    }

    /**
     * Set games
     *
     * @param string $games
     *
     * @return Team
     */
    public function setGames($games)
    {
        $this->games = $games;

        return $this;
    }

    /**
     * Get games
     *
     * @return string
     */
    public function getGames()
    {
        return $this->games;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->games = new ArrayCollection();
        $this->bets = new ArrayCollection();
        $this->coefficients = new ArrayCollection();
        $this->teamResult = new ArrayCollection();

    }

    /**
     * Add game
     *
     * @param \Andersen\SportsBettingBundle\Entity\Game $game
     *
     * @return Team
     */
    public function addGame(\Andersen\SportsBettingBundle\Entity\Game $game)
    {
        $this->games[] = $game;

        if (!$this->games->contains($game))
        {
            $this->games[] = $game;
            $game->addTeam($this);
        }

        return $this;
    }

    /**
     * Remove game
     *
     * @param \Andersen\SportsBettingBundle\Entity\Game $game
     */
    public function removeGame(\Andersen\SportsBettingBundle\Entity\Game $game)
    {
        $this->games->removeElement($game);
    }

    /**
     * Add bet
     *
     * @param \Andersen\SportsBettingBundle\Entity\Bet $bet
     *
     * @return Team
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
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
        ];
        // TODO: Implement jsonSerialize() method.
    }

    /**
     * Add coefficient
     *
     * @param \Andersen\SportsBettingBundle\Entity\Coefficient $coefficient
     *
     * @return Team
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
     * Add teamResult
     *
     * @param \Andersen\SportsBettingBundle\Entity\TeamResult $teamResult
     *
     * @return Team
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
