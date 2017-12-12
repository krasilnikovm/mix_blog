<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\MappedSuperclass
 */
class Human extends BaseUser
{
    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(
     *     message="Пожалуйста, введите имя",
     *     groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max=100,
     *     minMessage="Имя слишком короткое"
     *     maxMessage="Имя слишком длинное"
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(
     *     message="Пожалуйста, введите фамилию",
     *     groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     minMessage="Имя слишком короткое"
     *     maxMessage="Имя слишком длинное"
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $lastName;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     */
    protected $birthday;


    public function __construct()
    {
        parent::__construct();
    }


    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @param mixed $birthday
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getBirthday()
    {
        return $this->birthday;
    }
}
