<?php

namespace MN\MatchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MN\MatchBundle\Entity\TeamPlayer;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * TeamPlayer
 *
 * @ORM\Table(name="team_player")
 * @ORM\Entity(repositoryClass="MN\MatchBundle\Entity\TeamPlayerRepository")
 */
class TeamPlayer
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
     * @var boolean
     *
     * @ORM\Column(name="paid", type="boolean")
     */
    private $paid;

    /**
     * @ORM\ManyToOne(targetEntity="MN\MatchBundle\Entity\Team", inversedBy="team_players")
     * @ORM\JoinColumn(name="team_id", referencedColumnName="id")
     */
    private $team;

    /**
     * @ORM\ManyToOne(targetEntity="MN\PlayerBundle\Entity\Player", inversedBy="team_players")
     * @ORM\JoinColumn(name="player_id", referencedColumnName="id")
     */
    private $player;

    public function __construct(){
        $this->paid = 0;
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
     * Set paid
     *
     * @param boolean $paid
     * @return TeamPlayer
     */
    public function setPaid($paid)
    {
        $this->paid = $paid;

        return $this;
    }

    /**
     * Get paid
     *
     * @return boolean 
     */
    public function getPaid()
    {
        return $this->paid;
    }

    /**
     * Set team
     *
     * @param \MN\MatchBundle\Entity\Team $team
     * @return TeamPlayer
     */
    public function setTeam(\MN\MatchBundle\Entity\Team $team = null)
    {
        $this->team = $team;

        return $this;
    }

    /**
     * Get team
     *
     * @return \MN\MatchBundle\Entity\Team 
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * Set player
     *
     * @param \MN\PlayerBundle\Entity\Player $player
     * @return TeamPlayer
     */
    public function setPlayer($player = null)
    {
        if($player instanceof ArrayCollection){
            foreach($player as $tp){
                $team_player = new TeamPlayer();
                $team_player->setTeam($this->getTeam()->getId());
                $team_player->setPlayer($tp->getId());
                $team_player->setPaid(0);
            }
        }else{
            $this->player = $player;
        }
        return $this;
    }

    /**
     * Get player
     *
     * @return \MN\PlayerBundle\Entity\Player 
     */
    public function getPlayer()
    {
        return $this->player;
    }
}
