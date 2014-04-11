<?php

namespace MN\MatchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ResultType
 *
 * @ORM\Table(name="result_type")
 * @ORM\Entity(repositoryClass="MN\MatchBundle\Entity\ResultTypeRepository")
 */
class ResultType
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
     * @ORM\OneToMany(targetEntity="MN\MatchBundle\Entity\Team", mappedBy="result_type", cascade={"all"})
     */
    private $teams;

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
     * @return ResultType
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
     * @return ResultType
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
