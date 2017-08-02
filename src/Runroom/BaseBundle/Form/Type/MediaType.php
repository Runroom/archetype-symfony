<?php

namespace Runroom\BaseBundle\Form\Type;

use Sonata\MediaBundle\Form\Type\MediaType as BaseMediaType;
use Symfony\Component\Form\AbstractType;

class MediaType extends AbstractType
{
    public function getParent(): string
    {
        return BaseMediaType::class;
    }
}
