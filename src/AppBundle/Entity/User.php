<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @UniqueEntity(fields="email", message="Email already taken")
 */
class User extends Human
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    protected $plainPassword;

    /**
     * @ORM\Column(type="string", nullable=true, options={"default":""})
     */
    private $avatar;

    /**
     * @ORM\Column(type="boolean",  options={"default":false})
     */
    private $admin = false;

    /**
     * @ORM\OneToMany(targetEntity="Post", mappedBy="user")
     */
    private $posts;

    /**
     * @ORM\OneToMany(targetEntity="BookMarks", mappedBy="likedPosts")
     */
    private $bookMarks;



    public function __construct()
    {
        parent::__construct();
        $this->posts = new ArrayCollection();
        $this->bookMarks = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }


    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }


    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param mixed $avatar
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }

    /**
     * @return mixed
     */
    public function isAdmin()
    {
        return $this->admin;
    }

    /**
     * @param mixed $admin
     */
    public function setAdmin($admin)
    {
        $this->admin = $admin;
    }

    /**
     * Get admin
     *
     * @return boolean
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * Add post
     *
     * @param \AppBundle\Entity\Post $post
     *
     * @return User
     */
    public function addPost(\AppBundle\Entity\Post $post)
    {
        $this->posts[] = $post;

        return $this;
    }

    /**
     * Remove post
     *
     * @param \AppBundle\Entity\Post $post
     */
    public function removePost(\AppBundle\Entity\Post $post)
    {
        $this->posts->removeElement($post);
    }

    /**
     * Get posts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPosts()
    {
        return $this->posts;
    }



    /**
     * Add bookMark
     *
     * @param \AppBundle\Entity\BookMarks $bookMark
     *
     * @return User
     */
    public function addBookMark(\AppBundle\Entity\BookMarks $bookMark)
    {
        $this->bookMarks[] = $bookMark;

        return $this;
    }

    /**
     * Remove bookMark
     *
     * @param \AppBundle\Entity\BookMarks $bookMark
     */
    public function removeBookMark(\AppBundle\Entity\BookMarks $bookMark)
    {
        $this->bookMarks->removeElement($bookMark);
    }

    /**
     * Get bookMarks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBookMarks()
    {
        return $this->bookMarks;
    }

}
