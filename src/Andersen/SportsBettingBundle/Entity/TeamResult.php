<?php

namespace Andersen\SportsBettingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TeamResult
 *
 * @ORM\Table(name="team_result")
 * @ORM\Entity(repositoryClass="Andersen\SportsBettingBundle\Repository\TeamResultRepository")
 */
class TeamResult
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
     * Many TeamResults have One Game
     *
     * @ORM\ManyToOne(targetEntity="Andersen\SportsBettingBundle\Entity\Game", inversedBy="teamResult")
     */
    private $Game;

    /**
     * Many TeamResult have One Team
     *
     * @ORM\ManyToOne(targetEntity="Andersen\SportsBettingBundle\Entity\Team", inversedBy="teamResult" )
     */
    private $team;

    /**
     * @var integer
     *
     * 0 = draw
     * 1 = victory
     * 2 = loss
     *
     * @ORM\Column(name="gameResult", type="integer")
     */
    private $gameResult;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->teamGameResult = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set gameResult
     *
     * @param integer $gameResult
     *
     * @return TeamResult
     */
    public function setGameResult($gameResult)
    {
        $this->gameResult = $gameResult;

        return $this;
    }

    /**
     * Get gameResult
     *
     * @return integer
     */
    public function getGameResult()
    {
        return $this->gameResult;
    }

    /**
     * Add teamGameResult
     *
     * @param \Andersen\SportsBettingBundle\Entity\Game $teamGameResult
     *
     * @return TeamResult
     */
    public function addTeamGameResult(\Andersen\SportsBettingBundle\Entity\Game $teamGameResult)
    {
        $this->teamGameResult[] = $teamGameResult;

        return $this;
    }

    /**
     * Remove teamGameResult
     *
     * @param \Andersen\SportsBettingBundle\Entity\Game $teamGameResult
     */
    public function removeTeamGameResult(\Andersen\SportsBettingBundle\Entity\Game $teamGameResult)
    {
        $this->teamGameResult->removeElement($teamGameResult);
    }

    /**
     * Get teamGameResult
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTeamGameResult()
    {
        return $this->teamGameResult;
    }

    /**
     * Set team
     *
     * @param \Andersen\SportsBettingBundle\Entity\Team $team
     *
     * @return TeamResult
     */
    public function setTeam(\Andersen\SportsBettingBundle\Entity\Team $team = null)
    {
        $this->team = $team;

        return $this;
    }

    /**
     * Get team
     *
     * @return \Andersen\SportsBettingBundle\Entity\Team
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * Set teamGameResult
     *
     * @param \Andersen\SportsBettingBundle\Entity\Game $teamGameResult
     *
     * @return TeamResult
     */
    public function setTeamGameResult(\Andersen\SportsBettingBundle\Entity\Game $teamGameResult = null)
    {
        $this->teamGameResult = $teamGameResult;

        return $this;
    }
}
