<?php

namespace MN\MatchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MN\MatchBundle\Entity\TeamPlayer;
use \Doctrine\Common\Collections\ArrayCollection;

/**
 * Team
 *
 * @ORM\Table(name="team")
 * @ORM\Entity(repositoryClass="MN\MatchBundle\Entity\TeamRepository")
 */
class Team
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="goals_scored", type="integer")
     */
    private $goals_scored;

    /**
     * @ORM\ManyToOne(targetEntity="MN\MatchBundle\Entity\Game", inversedBy="teams")
     * @ORM\JoinColumn(name="game_id", referencedColumnName="id")
     */
    private $game;

    /**
     * @ORM\ManyToOne(targetEntity="MN\MatchBundle\Entity\ResultType", inversedBy="teams")
     * @ORM\JoinColumn(name="result_type_id", referencedColumnName="id")
     */
    private $result_type;

    /**
     * @ORM\ManyToOne(targetEntity="MN\MatchBundle\Entity\TeamCategory", inversedBy="teams")
     * @ORM\JoinColumn(name="team_category_id", referencedColumnName="id", nullable=true)
     */
    private $team_category;

    /**
     * @ORM\OneToMany(targetEntity="MN\MatchBundle\Entity\TeamPlayer", mappedBy="team", cascade={"all"})
     */
    private $team_players;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->team_players = new ArrayCollection();
    }

    public function __toString()
    {
        if($this->getTeamCategory() && $this->getTeamCategory()->getName()){
            return $this->getTeamCategory()->getName();
        }
        return $this->getName();
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
     * Set name
     *
     * @param string $name
     * @return Team
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
     * Set score
     *
     * @param integer $score
     * @return Team
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return integer
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set goals_scored
     *
     * @param integer $goalsScored
     * @return Team
     */
    public function setGoalsScored($goalsScored)
    {
        $this->goals_scored = $goalsScored;

        return $this;
    }

    /**
     * Get goals_scored
     *
     * @return integer 
     */
    public function getGoalsScored()
    {
        return $this->goals_scored;
    }

    /**
     * Set game
     *
     * @param \MN\MatchBundle\Entity\Game $game
     * @return Team
     */
    public function setGame(\MN\MatchBundle\Entity\Game $game = null)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * Get game
     *
     * @return \MN\MatchBundle\Entity\Game 
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * Set result_type
     *
     * @param \MN\MatchBundle\Entity\ResultType $resultType
     * @return Team
     */
    public function setResultType(\MN\MatchBundle\Entity\ResultType $resultType = null)
    {
        $this->result_type = $resultType;

        return $this;
    }

    /**
     * Get result_type
     *
     * @return \MN\MatchBundle\Entity\ResultType 
     */
    public function getResultType()
    {
        return $this->result_type;
    }

    /**
     * Set team_category
     *
     * @param \MN\MatchBundle\Entity\TeamCategory $teamCategory
     * @return Team
     */
    public function setTeamCategory(\MN\MatchBundle\Entity\TeamCategory $teamCategory = null)
    {
        $this->team_category = $teamCategory;

        return $this;
    }

    /**
     * Get team_category
     *
     * @return \MN\MatchBundle\Entity\TeamCategory 
     */
    public function getTeamCategory()
    {
        return $this->team_category;
    }

    /**
     * Add team_players
     *
     * @param \MN\MatchBundle\Entity\TeamPlayer $teamPlayers
     * @return Team
     */
    public function addTeamPlayer(\MN\MatchBundle\Entity\TeamPlayer $teamPlayers)
    {
        $this->team_players[] = $teamPlayers;

        return $this;
    }

    /**
     * Remove team_players
     *
     * @param \MN\MatchBundle\Entity\TeamPlayer $teamPlayers
     */
    public function removeTeamPlayer(\MN\MatchBundle\Entity\TeamPlayer $teamPlayers)
    {
        $this->team_players->removeElement($teamPlayers);
    }

    /**
     * Get team_players
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTeamPlayers()
    {
        return $this->team_players;
    }

    public function getPlayers(){
        $players = array();
        foreach ($this->getTeamPlayers() as $player) {
            $players[] = $player;
        }
        return $players;
    }

    public function addPlayer($player){
        if($player instanceof ArrayCollection){
            $this->setPlayers($player);
        }else{
            $team_player = new TeamPlayer();
            $team_player->setTeam($this);
            $team_player->setPlayer($player);
            $team_player->setPaid(0);
            $this->addTeamPlayer($team_player);
        }
    }

    public function setPlayers($players){
        foreach ($players as $player) {
            $team_player = new TeamPlayer();
            $team_player->setTeam($this);
            $team_player->setPlayer($player);
            $team_player->setPaid(0);
            $this->addTeamPlayer($team_player);
        }
    }

    public function removePlayer($player){
        $this->getPlayers()->removeElement($player);
    }
}
