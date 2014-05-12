<?php

namespace MN\MatchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TeamCategory
 *
 * @ORM\Table(name="team_category")
 * @ORM\Entity(repositoryClass="MN\MatchBundle\Entity\TeamCategoryRepository")
 */
class TeamCategory
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="MN\MatchBundle\Entity\Team", mappedBy="team_category")
     */
    private $teams;

    /**
     * @ORM\OneToOne(targetEntity="MN\UsefulBundle\Entity\Image", inversedBy="team_category", cascade={"all"})
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id", nullable=true)
     */
    private $image;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->teams = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
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
     * @return TeamCategory
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
     * Add teams
     *
     * @param \MN\MatchBundle\Entity\Team $teams
     * @return TeamCategory
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

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    public function getResults(){
        $results = array(
            'win' => array(),
            'loss' => array(),
            'draw' => array(),
        );
        foreach($this->getTeams() as $team){
            if($team->getGame()->getPlayed()){
                $results[$team->getResultType()][] = $team;
            }
        }
        return $results;
    }
}
