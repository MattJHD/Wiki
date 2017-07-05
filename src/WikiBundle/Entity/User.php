<?php

namespace WikiBundle\Entity;

use WikiBundle\Entity\DoctrineTrait\IdTrait;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * Class User
 *
 * @author "William BLOCH" <bloch.william@gmail.com>
 * @ORM\Entity(repositoryClass="WikiBundle\Repository\UserRepository")
 * @ORM\Table()
 */
class User implements UserInterface
{
    use IdTrait;

    /**
     * @ORM\Column(type="string")
     * @Type("string")
     */
    private $firstname;

    /**
     * @ORM\Column(type="string")
     * @Type("string")
     */
    private $lastname;

    /**
     * @var string
     * @ORM\Column(unique=true)
     *
     * @Type("string")
     */
    private $username;

    /**
     * @var Salt
     * @ORM\Column()
     *
     * @Type("string")
     */
    private $salt;

    /**
     * @var string
     */
    private $rawPassword;

    /**
     * @var Password
     * @ORM\Column()
     *
     * @Type("string")
     */
    private $password;

    /**
     * @ORM\Column(type="string")
     * @Type("string")
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity="Role", inversedBy="users", cascade={"persist", "remove", "merge"})
     * @Type("WikiBundle\Entity\User")
     */
    private $role;


    public function __construct() {
       $this->salt=md5(time());
    }

    //GETTER
    function getId() {
        return $this->id;
    }

    function getFirstname() {
        return $this->firstname;
    }

    function getLastname() {
        return $this->lastname;
    }

    function getUsername() {
        return $this->username;
    }

    function getSalt() {
        return $this->salt;
    }

    function getRawPassword() {
        return $this->rawPassword;
    }

    function getPassword() {
        return $this->password;
    }

    function getEmail() {
        return $this->email;
    }

    function getRole() {
        return $this->role;
    }

    //SETTER
    function setId($id) {
        $this->id = $id;
    }

    function setFirstname($firstname) {
        $this->firstname = $firstname;
    }

    function setLastname($lastname) {
        $this->lastname = $lastname;
    }

    function setUsername($username) {
        $this->username = $username;
    }

    function setSalt($salt) {
        $this->salt = $salt;
    }

    function setRawPassword($rawPassword) {
        $this->rawPassword = $rawPassword;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setRole($role) {
        $this->role = $role;
    }

  /**
   * Set date_creation
   *
   * @param \DateTime $dateCreation
   * @return User
   */
    public function setDateCreation($dateCreation)
    {
        $this->date_creation = $dateCreation;

        return $this;
    }

    public function getRoles() {
        return ['ROLE_ADMIN'];
    }

    public function eraseCredentials() {
        $this->rawPassword =null;
    }
}
