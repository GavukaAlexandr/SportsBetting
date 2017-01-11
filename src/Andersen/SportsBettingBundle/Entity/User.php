<?php

namespace Andersen\SportsBettingBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraint as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
Class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

//    overriding FOS User Bundle Form registration (enter hea you custom fields)
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $name;

    /**
     * @var int
     *
     * @ORM\Column(name="money", type="integer")
     */
    protected $money = 0;

    /**
     * One User has many Bets.
     * @ORM\OneToMany(targetEntity="Andersen\SportsBettingBundle\Entity\Bet", mappedBy="user")
     */
    protected $bets;


    public function __construct()
    {
        parent::__construct();
        $this->bets = new ArrayCollection();
    }

    public function setMoney($money)
    {
        $this->money = $money;

        return $this;
    }

    public function getMoney()
    {
        return $this->money;
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
     * Get bets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBets()
    {
        return $this->bets;
    }
}
