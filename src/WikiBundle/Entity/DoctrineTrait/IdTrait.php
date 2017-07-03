<?php

namespace AppBundle\Entity\DoctrineTrait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class IdTrait
 *
 * @author "William BLOCH" <william.bloch@gmail.com>
 */
trait IdTrait
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
