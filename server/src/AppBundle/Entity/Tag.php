<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Tag
 *
 * @ORM\Table(name="tag")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TagRepository")
 */
class Tag
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Groups({"tag", "image"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="tag", type="string", length=255, unique=true)
     *
     * @Groups({"tag", "image"})
     */
    private $tag;

    /**
     * @ORM\ManyToMany(targetEntity="Image", inversedBy="tags")
     * @ORM\JoinTable(name="tags")
     */
    private $images;

    public function __construct() {
        $this->images = new ArrayCollection();
    }


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
     * Set tag
     *
     * @param string $tag
     *
     * @return Tag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get tag
     *
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Add images
     *
     * @param Image $image
     * @return Tag
     */
    public function addImages(Image $image)
    {
        $this->images[] = $image;
        return $this;
    }

    /**
     * Remove images
     *
     * @param Image $image
     * @return Tag
     */
    public function removeImages(Image $image)
    {
        $this->images->removeElement($image);
        return $this;
    }

    /**
     * Get images
     *
     * @return ArrayCollection
     */
    public function getImages()
    {
        return $this->images;
    }
}

