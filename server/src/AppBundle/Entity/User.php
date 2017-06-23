<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Groups({"user", "image", "comment"})
     */
    protected $id;

    /**
     * @var string
     *
     * @Groups({"user", "image", "comment"})
     */
    protected $username;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     *
     * @Groups({"user"})
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified_at", type="datetime", nullable=true)
     *
     * @Groups({"user"})
     */
    private $modifiedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     *
     * @Groups({"user"})
     */
    private $deletedAt;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_admin", type="boolean")
     *
     * @Groups({"user"})
     */
    private $isAdmin = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_private", type="boolean")
     *
     * @Groups({"user"})
     */
    private $isPrivate = false;

    /**
     * @ORM\OneToMany(targetEntity="Image", mappedBy="uploadedBy")
     *
     * @Groups({"user"})
     */
    private $images;

    /**
     * @ORM\ManyToMany(targetEntity="Image", mappedBy="likes")
     *
     * @Groups({"user"})
     */
    private $likes;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="following")
     *
     * @Groups({"user"})
     */
    private $followers;

    /**
    * @ORM\ManyToMany(targetEntity="User", inversedBy="followers")
    * @ORM\JoinTable(name="follow",
    *      joinColumns={@ORM\JoinColumn(name="user", referencedColumnName="id")},
    *      inverseJoinColumns={@ORM\JoinColumn(name="follow", referencedColumnName="id")}
    *      )
    *
    * @Groups({"user"})
    */
    private $following;


    public function __construct() {
        $this->images = new ArrayCollection();
        $this->likes = new ArrayCollection();
        $this->followers = new ArrayCollection();
        $this->following = new ArrayCollection();
        $this->createdAt = new \DateTime('now');
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set modifiedAt
     *
     * @param \DateTime $modifiedAt
     *
     * @return User
     */
    public function setModifiedAt($modifiedAt)
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    /**
     * Get modifiedAt
     *
     * @return \DateTime
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     *
     * @return User
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * Set isAdmin
     *
     * @param boolean $isAdmin
     *
     * @return User
     */
    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    /**
     * Get isAdmin
     *
     * @return bool
     */
    public function getIsAdmin()
    {
        return $this->isAdmin;
    }

    /**
     * Set isPrivate
     *
     * @param boolean
     *
     * @return User
     */
    public function setIsPrivate($isPrivate)
    {
        $this->isPrivate = $isPrivate;

        return $this;
    }

    /**
     * Get isPrivate
     *
     * @return bool
     */
    public function getIsPrivate()
    {
        return $this->isPrivate;
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

    /**
     * Add likes
     *
     * @param Image $image
     * @return User
     */
    public function addLikes(Image $image)
    {
        $image->addLikes($this);
        return $this;
    }

    /**
     * Remove likes
     *
     * @param Image $image
     * @return User
     */
    public function removeLikes(Image $image)
    {
        $image->removeLikes($this);
        return $this;
    }

    /**
     * Get likes
     *
     * @return ArrayCollection
     */
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * Get followers
     *
     * @return array
     */
    public function getFollowers()
    {
        return $this->getBasicUsers($this->followers);
    }

    /**
     * Add following
     *
     * @param User $user
     * @return User
     */
    public function addFollowing(User $user)
    {
        $this->following[] = $user;
        return $this;
    }

    /**
     * Remove following
     *
     * @param User $user
     * @return User
     */
    public function removeFollowing(User $user)
    {
        $this->following->removeElement($user);
        return $this;
    }

    /**
     * Get following
     *
     * @return array
     */
    public function getFollowing()
    {
        return $this->getBasicUsers($this->following);
    }

    /**
     * @return array
     */
    private function getBasicUsers($collection)
    {
        $usersArray = [];
        foreach ($collection as $user) {
            $usersArray[] = array(
                'id' => $user->getId(),
                'username' => $user->getUsername());
        }
        return $usersArray;
    }

    public function resetFollow()
    {
        $this->following->clear();
        foreach ($this->followers as $user) {
            $user->removeFollowing($this);
        }
        $this->followers->clear();
    }
}

