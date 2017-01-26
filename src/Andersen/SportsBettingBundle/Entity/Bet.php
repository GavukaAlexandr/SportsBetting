<?php

namespace Andersen\SportsBettingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

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
     * Many bets have one Team
     * @ORM\ManyToOne(targetEntity="Andersen\SportsBettingBundle\Entity\Team", inversedBy="bets")
     */
    private $team;

    /**
     * Many Bet have One Game.
     * @ORM\ManyToOne(targetEntity="Andersen\SportsBettingBundle\Entity\Game", inversedBy="bets")
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
     * @var int
     *
     * @ORM\Column(name="money", type="integer")
     */
    private $money;

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
     * @return int
     */
    public function getMoney(): int
    {
        return $this->money;
    }

    /**
     * @param int $money
     */
    public function setMoney(int $money)
    {
        $this->money = $money;
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
            'user' => $this->getUser(),
            'game' => $this->getGame(),
            'team' => $this->getTeam(),
            'BetValue' => $this->getBetsValue(),
            'money' => $this->getMoney(),
        ];
        // TODO: Implement jsonSerialize() method.
    }
}
