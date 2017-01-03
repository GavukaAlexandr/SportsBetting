<?php

namespace Andersen\SportsBettingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bet
 *
 * @ORM\Table(name="bet")
 * @ORM\Entity(repositoryClass="Andersen\SportsBettingBundle\Repository\BetRepository")
 */
class Bet implements \JsonSerializable
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
     * One Bet have One Sport
     * @ORM\OneToOne(targetEntity="Andersen\SportsBettingBundle\Entity\Sport")
     */
    private $sport;

    /**
     * One Bet have One Team
     * @ORM\OneToOne(targetEntity="Andersen\SportsBettingBundle\Entity\Team")
     */
    private $team;

    /**
     * One Bet have One Game.
     * @ORM\OneToOne(targetEntity="Andersen\SportsBettingBundle\Entity\Game")
     */
    private $game;

    /**
     * @var int
     *
     * @ORM\Column(name="bets_value", type="integer")
     */
    private $betsValue;

    /**
     * Many bets have one user
     * @ORM\ManyToOne(targetEntity="Andersen\SportsBettingBundle\Entity\User", inversedBy="bets")
     */
    private $user;

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
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
     * Set sport
     *
     * @param string $sport
     *
     * @return Bet
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
     * @return mixed
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * @param mixed $team
     */
    public function setTeam($team)
    {
        $this->team = $team;
    }

    /**
     * Set game
     *
     * @param string $game
     *
     * @return Bet
     */
    public function setGame($game)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * Get game
     *
     * @return string
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * Set betsValue
     *
     * @param string $betsValue
     *
     * @return Bet
     */
    public function setBetsValue($betsValue)
    {
        $this->betsValue = $betsValue;

        return $this;
    }

    /**
     * Get betsValue
     *
     * @return string
     */
    public function getBetsValue()
    {
        return $this->betsValue;
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

        // TODO: Implement jsonSerialize() method.
    }
}
