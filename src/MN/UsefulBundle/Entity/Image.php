<?php

namespace MN\UsefulBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Image
 *
 * @ORM\Table(name="image")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Image
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
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * Image path
     *
     * @var string
     *
     * @ORM\Column(type="text", length=255, nullable=false)
     */
    protected $path;

    /**
     * Image extension
     *
     * @var string
     *
     * @ORM\Column(type="extension", length=255, nullable=false)
     */
    protected $extension;

    /**
     * Image file
     *
     * @var File
     *
     * @Assert\File(
     *     maxSize = "2M",
     *     mimeTypes = {"image/jpeg", "image/gif", "image/png", "image/tiff"},
     *     maxSizeMessage = "The maxmimum allowed file size is 2MB.",
     *     mimeTypesMessage = "Only the filetypes image are allowed."
     * )
     */
    protected $file;

    /**
     * @ORM\OneToOne(targetEntity="MN\PlayerBundle\Entity\Player", mappedBy="image")
     */
    private $player;

    /**
     * @ORM\OneToOne(targetEntity="MN\MatchBundle\Entity\TeamCategory", mappedBy="image")
     */
    private $team_category;

    private $temp;

    /**
     * Called before saving the entity
     *
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->file) {
            // do whatever you want to generate a unique name
            $filename = sha1(uniqid(mt_rand(), true));
            $this->path = $filename.'.'.$this->file->guessExtension();
            $this->setName($this->file->getClientOriginalName());
            $this->extension = $this->file->guessExtension();
        }
    }

    /**
     * Called before entity removal
     *
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }

    /**
     * Called after entity persistence
     *
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->file) {
            return;
        }

        // check if we have an old image
        if (isset($this->temp)) {
            // delete the old image
            unlink($this->temp);
            // clear the temp image path
            $this->temp = null;
        }

        $this->file->move(
            $this->getUploadRootDir(),
            $this->path
        );

        // clean up the file property as we don't need it anymore
        $this->file = null;
    }

    public function getUploadRootDir(){
        return 'images/'.$this->getType();
    }

    public function getAbsolutePath(){
        return $this->getUploadRootDir().'/'.$this->getPath();
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
     * @return Image
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
     * @param \MN\UsefulBundle\Entity\Image $file
     */
    public function setFile($file)
    {
        $this->file = $file;

        // check if we have an old image path
        if (is_file($this->getAbsolutePath())) {
            // store the old name to delete after the update
            $this->temp = $this->getAbsolutePath();
            $this->path = null;
        } else {
            $this->path = 'initial';
        }
    }

    /**
     * @return \MN\UsefulBundle\Entity\Image
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set player
     *
     * @param \MN\PlayerBundle\Entity\Player $player
     * @return Image
     */
    public function setPlayer(\MN\PlayerBundle\Entity\Player $player = null)
    {
        $this->player = $player;

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

    /**
     * Set team_category
     *
     * @param \MN\MatchBundle\Entity\TeamCategory $team_category
     * @return Image
     */
    public function setTeamCategory(\MN\MatchBundle\Entity\TeamCategory $team_category = null)
    {
        $this->team_category = $team_category;

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
     * @param string $extension
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
    }

    /**
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

}
