<?php

namespace Runroom\TranslationsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Message
 *
 * @ORM\Table(name="messages")
 * @ORM\Entity()
 */
class Message
{
    use ORMBehaviors\Translatable\Translatable;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="message_key", type="string", length=255, nullable=false)
     */
    private $key;

    public function __toString()
    {
        return $this->getId() ? $this->getKey() . '' : 'Message';
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set key
     *
     * @param string $key
     *
     * @return Message
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get key
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set value
     *
     * @param string $value
     *
     * @return Message
     */
    public function setValue($value)
    {
        $this->translate()->setValue($value);

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->translate()->getValue();
    }
}
