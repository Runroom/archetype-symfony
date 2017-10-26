<?php

namespace Runroom\TranslationsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Entity
 */
class MessageTranslation
{
    use ORMBehaviors\Translatable\Translation;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $value;

    public function setValue(?string $value): MessageTranslation
    {
        $this->value = $value;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }
}
