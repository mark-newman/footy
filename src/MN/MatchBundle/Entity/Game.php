<?php

namespace MN\MatchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MN\MatchBundle\Entity\Team;

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
     * @ORM\OneToMany(targetEntity="MN\MatchBundle\Entity\Team", mappedBy="game", cascade={"all"})
     */
    private $teams;

    /**
     * @var string
     *
     * @ORM\Column(name="report", type="text", nullable=true)
     */
    private $report;

    /**
     * @var integer
     *
     * @ORM\Column(name="pitch", type="integer", length=255, nullable=true)
     */
    private $pitch;

    /**
     * @var boolean
     *
     * @ORM\Column(name="played", type="boolean")
     */
    private $played;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->teams = new \Doctrine\Common\Collections\ArrayCollection();
        $this->addTeam(new Team());
        $this->addTeam(new Team());
        $this->date = new \DateTime();
        $this->setPlayed(0);
        $this->setCost(65);
        $this->setSubs(6);
    }

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
     * Add teams
     *
     * @param \MN\MatchBundle\Entity\Team $team
     * @return Game
     */
    public function addTeam(\MN\MatchBundle\Entity\Team $team)
    {
        $this->teams[] = $team;

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

    public function getHomeTeam(){
        return $this->teams[0];
    }

    public function getAwayTeam(){
        return $this->teams[1];
    }

    /**
     * @param string $report
     */
    public function setReport($report)
    {
        $this->report = $report;
    }

    /**
     * @return string
     */
    public function getReport()
    {
        return $this->report;
    }

    /**
     * @param int $pitch
     */
    public function setPitch($pitch)
    {
        $this->pitch = $pitch;
    }

    /**
     * @return int
     */
    public function getPitch()
    {
        return $this->pitch;
    }

    /**
     * @param boolean $played
     */
    public function setPlayed($played)
    {
        $this->played = $played;
    }

    /**
     * @return boolean
     */
    public function getPlayed()
    {
        return $this->played;
    }

}
