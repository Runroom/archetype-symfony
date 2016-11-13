<?php

namespace Runroom\TranslationsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Table(name="messages_translations")
 * @ORM\Entity()
 */
class MessageTranslation
{
    use ORMBehaviors\Translatable\Translation;

    /**
     * @ORM\Column(name="value", type="text", nullable=true)
     */
    private $value;

    /**
     * Set value.
     *
     * @param string $value
     *
     * @return MessageTranslation
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value.
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}
