<?php

namespace Andersen\SportsBettingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Game
 *
 * @ORM\Table(name="game")
 * @ORM\Entity(repositoryClass="Andersen\SportsBettingBundle\Repository\GameRepository")
 */
class Game
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
     * @ORM\Column(name="teamWinner", type="string", length=255)
     */
    private $teamWinner;


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
        $this->teams[] = $team;

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
}
