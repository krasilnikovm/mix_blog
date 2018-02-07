<?php
/**
 * Created by PhpStorm.
 * User: tanja
 * Date: 09.12.2017
 * Time: 0:04
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="posts")
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue("AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="posts")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\Column(type="integer")
     */
    private $countLikes = 0;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $article;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity="BookMarks", mappedBy="usersWhichAddedBookMark")
     */
    private $usersLikes;


    public function __construct()
    {
        $this->usersLikes = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


    /**
     * @return mixed
     */
    public function getCountLikes()
    {
        return $this->countLikes;
    }

    /**
     * @param mixed $countLikes
     */
    public function setCountLikes($countLikes)
    {
        $this->countLikes = $countLikes;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @param mixed $article
     */
    public function setArticle($article)
    {
        $this->article = $article;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }


    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Post
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add usersLike
     *
     * @param \AppBundle\Entity\BookMarks $usersLike
     *
     * @return Post
     */
    public function addUsersLike(\AppBundle\Entity\BookMarks $usersLike)
    {
        $this->usersLikes[] = $usersLike;

        return $this;
    }

    /**
     * Remove usersLike
     *
     * @param \AppBundle\Entity\BookMarks $usersLike
     */
    public function removeUsersLike(\AppBundle\Entity\BookMarks $usersLike)
    {
        $this->usersLikes->removeElement($usersLike);
    }

    /**
     * Get usersLikes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsersLikes()
    {
        return $this->usersLikes;
    }

}
