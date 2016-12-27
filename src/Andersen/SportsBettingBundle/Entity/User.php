<?php

namespace Andersen\SportsBettingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="Andersen\SportsBettingBundle\Repository\UserRepository")
 */
class User
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
     * @var int
     *
     * @ORM\Column(name="money", type="integer")
     */
    private $money;

    /**
     * One User has many Bets.
     * @ORM\OneToMany(targetEntity="Andersen\SportsBettingBundle\Entity\Bet", mappedBy="user")
     */
    private $bets;

    /**
     * @return mixed
     */
    public function getBets()
    {
        return $this->bets;
    }

    /**
     * @param mixed $bets
     */
    public function setBets($bets)
    {
        $this->bets = $bets;
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
     * @return User
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
     * Set money
     *
     * @param integer $money
     *
     * @return User
     */
    public function setMoney($money)
    {
        $this->money = $money;

        return $this;
    }

    /**
     * Get money
     *
     * @return int
     */
    public function getMoney()
    {
        return $this->money;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->bets = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add bet
     *
     * @param \Andersen\SportsBettingBundle\Entity\Bet $bet
     *
     * @return User
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
}
