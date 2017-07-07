<?php
namespace WikiBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use WikiBundle\Entity\DoctrineTrait\IdTrait;
use JMS\Serializer\Annotation\Type;


/**
 * Description of Theme
 *
 * @author matthieudurand
 * @ORM\Entity(repositoryClass="WikiBundle\Repository\ThemeRepository")
 * @ORM\Table()
 */
class Theme {

    use IdTrait;

    /**
     * @ORM\Column(type="string")
     * @Type("string")
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="themes", cascade={"persist", "merge"})
     * @Type("WikiBundle\Entity\User")
     */
    private $user;


    //GETTERS
    function getName() {
        return $this->name;
    }

    function getUser() {
        return $this->user;
    }


    //SETTERS
    function setName($name) {
        $this->name = $name;
    }

    function setUser($user) {
        $this->user = $user;
    }
}
