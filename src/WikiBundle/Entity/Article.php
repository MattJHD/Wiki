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
     * @ORM\Column(type="string")
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
     */
    private $media;

    /**
     * @var null|string
     * @ORM\Column(nullable=true)
     * @Type("string")
     */
    private $pathname;

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


}
