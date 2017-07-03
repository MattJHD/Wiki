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
    private $nom;
    
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="theme", cascade={"persist", "merge"})
     * @Type("AppBundle\Entity\Theme")
     */
    private $user;
    
    /**
     * @ORM\ManyToMany(targetEntity="Article", inversedBy="themes", cascade={"persist", "merge"})
     * @Type("ArrayCollection<AppBundle\Entity\Article>")
     */
    private $articles;
    
    //GETTERS
    function getNom() {
        return $this->nom;
    }

    function getUser() {
        return $this->user;
    }

    function getArticles() {
        return $this->articles;
    }

    //SETTERS
    function setNom($nom) {
        $this->nom = $nom;
    }

    function setUser($user) {
        $this->user = $user;
    }

    function setArticles($articles) {
        $this->articles = $articles;
    }


}
