<?php
namespace WikiBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use WikiBundle\Entity\DoctrineTrait\IdTrait;
use JMS\Serializer\Annotation\Type;

/**
 * Description of Article
 *
 * @author matthieudurand
 * @ORM\Entity(repositoryClass="WikiBundle\Repository\ArticleRepository")
 * @ORM\Table()
 */
class Article {

    use IdTrait;

    /**
     * @ORM\Column(type="string")
     * @Type("string")
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Type("string")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Type("DateTime<'Y-m-d'>")
     */
    private $date_creation;

    /**
     * @ORM\ManyToMany(targetEntity="Theme", cascade={"persist", "merge"})
     * @Type("ArrayCollection<WikiBundle\Entity\Theme>")
     */
    private $themes;

    /**
     * @var null|UploadedFile
     * @Type("string")
     */
    private $media;

    /**
     * @var null|string
     * @ORM\Column(type="text", nullable=true)
     * @Type("string")
     */
    private $pathname;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="articles", cascade={"persist", "remove", "merge"})
     * @Type("WikiBundle\Entity\User")
     */
    private $user;

    //GETTERS
    function getName() {
        return $this->name;
    }

    function getDescription() {
        return $this->description;
    }

    function getDate_creation() {
        return $this->date_creation;
    }

    function getThemes() {
        return $this->themes;
    }

    function getMedia() {
        return $this->media;
    }

    function getPathname() {
        return $this->pathname;
    }

    function getUser() {
        return $this->user;
    }


    //SETTERS
    function setName($name) {
        $this->name = $name;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setDate_creation($date_creation) {
        $this->date_creation = $date_creation;
    }

    function setThemes($themes) {
        $this->themes = $themes;
    }

    function setMedia(UploadedFile $media) {
        $this->media = $media;
    }

    function setPathname($pathname) {
        $this->pathname = $pathname;
    }

    function setUser($user) {
        $this->user = $user;
    }


}
