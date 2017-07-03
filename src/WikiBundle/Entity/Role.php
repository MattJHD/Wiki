<?php
namespace WikiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Type;
use WikiBundle\Entity\DoctrineTrait\IdTrait;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Description of ROLE
 *
 * @author william BLOCH
 * @ORM\Entity(repositoryClass="WikiBundle\Repository\RoleRepository")
 * @ORM\Table()
 */
class Role {

    use IdTrait;

    /**
     * @ORM\Column()
     *
     * @Type("string")
     */
    private $name;

    /**
     *
     * @ORM\OneToMany(targetEntity="User", inversedBy="role", cascade={"persist", "remove", "merge"})
     *
     * @Type("WikiBundle\Entity\User")
     */
    private $users;


    //GETTER
    function getId() {
      return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getUsers() {
        return $this->users;
    }

    //SETTER
    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setUsers($users) {
        $this->users = $users;
    }
}
