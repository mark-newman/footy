<?php

namespace MN\MatchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Game
 *
 * @ORM\Table(name="game")
 * @ORM\Entity(repositoryClass="MN\MatchBundle\Entity\GameRepository")
 */
class Game
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="cost", type="integer")
     */
    private $cost;

    /**
     * @var string
     *
     * @ORM\Column(name="subs", type="decimal")
     */
    private $subs;

    /**
     * @ORM\OneToMany(targetEntity="MN\MatchBundle\Entity\Team", mappedBy="result_type", cascade={"all"})
     */
    private $teams;

    public function __toString(){
        return date('d/m/Y', $this->getDate()->getTimestamp());
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
     * Set date
     *
     * @param \DateTime $date
     * @return Game
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set cost
     *
     * @param integer $cost
     * @return Game
     */
    public function setCost($cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * Get cost
     *
     * @return integer 
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Set subs
     *
     * @param string $subs
     * @return Game
     */
    public function setSubs($subs)
    {
        $this->subs = $subs;

        return $this;
    }

    /**
     * Get subs
     *
     * @return string 
     */
    public function getSubs()
    {
        return $this->subs;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->teams = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add teams
     *
     * @param \MN\MatchBundle\Entity\Team $teams
     * @return Game
     */
    public function addTeam(\MN\MatchBundle\Entity\Team $teams)
    {
        $this->teams[] = $teams;

        return $this;
    }

    /**
     * Remove teams
     *
     * @param \MN\MatchBundle\Entity\Team $teams
     */
    public function removeTeam(\MN\MatchBundle\Entity\Team $teams)
    {
        $this->teams->removeElement($teams);
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
}
