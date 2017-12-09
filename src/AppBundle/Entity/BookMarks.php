<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table("bookmarks")
 */
class BookMarks
{
    /**
     * @ORM\Id;
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="bookMarks")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $likedPosts;

    /**
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="usersLikes")
     * @ORM\JoinColumn(name="id_post", referencedColumnName="id")
     */
    private $usersWhichAddedBookMark;


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
     * Set likedPosts
     *
     * @param \AppBundle\Entity\User $likedPosts
     *
     * @return BookMarks
     */
    public function setLikedPosts(\AppBundle\Entity\User $likedPosts = null)
    {
        $this->likedPosts = $likedPosts;

        return $this;
    }

    /**
     * Get likedPosts
     *
     * @return \AppBundle\Entity\User
     */
    public function getLikedPosts()
    {
        return $this->likedPosts;
    }

    /**
     * Set usersWhichAddedBookMark
     *
     * @param \AppBundle\Entity\Post $usersWhichAddedBookMark
     *
     * @return BookMarks
     */
    public function setUsersWhichAddedBookMark(\AppBundle\Entity\Post $usersWhichAddedBookMark = null)
    {
        $this->usersWhichAddedBookMark = $usersWhichAddedBookMark;

        return $this;
    }

    /**
     * Get usersWhichAddedBookMark
     *
     * @return \AppBundle\Entity\Post
     */
    public function getUsersWhichAddedBookMark()
    {
        return $this->usersWhichAddedBookMark;
    }
}
