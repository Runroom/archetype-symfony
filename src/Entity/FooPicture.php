<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
final class FooPicture
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    public ?int $id;

    /**
     * @ORM\ManyToOne(targetEntity="FooEntity", inversedBy="pictures", fetch="EAGER")
     */
    public ?FooEntity $foo = null;

    /**
     * @ORM\ManyToOne(targetEntity="Media", inversedBy="foo_picture", cascade={"persist"}, fetch="LAZY")
     */
    public ?Media $image = null;
}
