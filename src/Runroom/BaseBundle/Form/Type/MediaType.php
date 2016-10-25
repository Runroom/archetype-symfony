<?php

namespace Runroom\BaseBundle\Form\Type;

use Sonata\MediaBundle\Form\Type\MediaType as BaseMediaType;

class MediaType extends BaseMediaType
{
    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'media_type';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
