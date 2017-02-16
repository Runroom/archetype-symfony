<?php

namespace Runroom\BaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Sonata\MediaBundle\Form\Type\MediaType as BaseMediaType;

class MediaType extends AbstractType
{
    public function getParent()
    {
        return BaseMediaType::class;
    }
}
