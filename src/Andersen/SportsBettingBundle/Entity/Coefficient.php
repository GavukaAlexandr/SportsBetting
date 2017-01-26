<?php

namespace Andersen\SportsBettingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Coefficient
 *
 * @ORM\Table(name="coefficient")
 * @ORM\Entity(repositoryClass="Andersen\SportsBettingBundle\Repository\CoefficientRepository")
 */
class Coefficient implements \JsonSerializable
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
     *@var $team
     *
     * Many Coefficients have One Team
     * @ORM\ManyToOne(targetEntity="Andersen\SportsBettingBundle\Entity\Team", inversedBy="coefficients")
     *
     */
    private $team;

    /**
     *@var $game
     *
     * Many Coefficients have One Game
     * @ORM\ManyToOne(targetEntity="Andersen\SportsBettingBundle\Entity\Game", inversedBy="coefficients")
     */
    private $game;

    /**
     * @var string
     *
     * @ORM\Column(name="typeCoefficient", type="string", length=255)
     */
    private $typeCoefficient;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=255)
     */
    private $value;


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
     * Set team
     *
     * @param string $team
     *
     * @return Coefficient
     */
    public function setTeam($team)
    {
        $this->team = $team;

        return $this;
    }

    /**
     * Get team
     *
     * @return string
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * Set game
     *
     * @param string $game
     *
     * @return Coefficient
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
     * Set typeCoefficient
     *
     * @param string $typeCoefficient
     *
     * @return Coefficient
     */
    public function setTypeCoefficient($typeCoefficient)
    {
        $this->typeCoefficient = $typeCoefficient;

        return $this;
    }

    /**
     * Get typeCoefficient
     *
     * @return string
     */
    public function getTypeCoefficient()
    {
        return $this->typeCoefficient;
    }

    /**
     * Set value
     *
     * @param string $value
     *
     * @return Coefficient
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
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
            'type' => $this->getTypeCoefficient(),
            'value' => $this->getValue(),
        ];
        // TODO: Implement jsonSerialize() method.
    }
}
