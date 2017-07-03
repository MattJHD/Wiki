<?php

namespace WikiBundle\Entity\DoctrineTrait;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Type;

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
     * @Type("string")
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
