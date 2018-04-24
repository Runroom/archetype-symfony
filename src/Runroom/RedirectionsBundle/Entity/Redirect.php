<?php

namespace Runroom\RedirectionsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Runroom\BaseBundle\Behaviors as Behaviors;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(indexes={
 *     @ORM\Index(columns={"source", "publish"}),
 * })
 * @DoctrineAssert\UniqueEntity("source")
 */
class Redirect
{
    use Behaviors\Publishable;

    const PERMANENT = 301;
    const TEMPORAL = 302;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotNull
     * @Assert\Length(max=500)
     * @Assert\Regex("/^\/.*$/")
     * @ORM\Column(type="string", length=500, unique=true)
     */
    private $source;

    /**
     * @Assert\NotNull
     * @Assert\Length(max=500)
     * @Assert\Regex("/^(\/|https?:\/\/).*$/")
     * @Assert\NotEqualTo(propertyPath="source")
     * @ORM\Column(type="string", length=500)
     */
    private $destination;

    /**
     * @Assert\Choice(choices = {
     *     Redirect::PERMANENT,
     *     Redirect::TEMPORAL,
     * })
     * @ORM\Column(type="integer")
     */
    private $httpCode = self::PERMANENT;

    public function __toString(): string
    {
        return (string) $this->getSource();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setSource(?string $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setDestination(?string $destination): self
    {
        $this->destination = $destination;

        return $this;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setHttpCode(?int $httpCode): self
    {
        $this->httpCode = $httpCode;

        return $this;
    }

    public function getHttpCode(): ?int
    {
        return $this->httpCode;
    }
}
