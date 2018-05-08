<?php

namespace Archetype\DemoBundle\Model;

use Archetype\DemoBundle\Entity\Contact as EntityContact;

class Contact
{
    protected $name;
    protected $email;
    protected $phone;
    protected $subject = EntityContact::SUBJECT_GENERAL;
    protected $type;
    protected $preferences = [];
    protected $comment;
    protected $newsletter;
    protected $privacyPolicy;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getSubject(): ?int
    {
        return $this->subject;
    }

    public function setSubject(?int $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(?int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPreferences(): ?array
    {
        return $this->preferences;
    }

    public function setPreferences(?array $preferences): self
    {
        $this->preferences = $preferences;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getNewsletter(): ?bool
    {
        return $this->newsletter;
    }

    public function setNewsletter(?bool $newsletter): self
    {
        $this->newsletter = $newsletter;

        return $this;
    }

    public function getPrivacyPolicy(): ?bool
    {
        return $this->privacyPolicy;
    }

    public function setPrivacyPolicy(?bool $privacyPolicy): self
    {
        $this->privacyPolicy = $privacyPolicy;

        return $this;
    }
}
