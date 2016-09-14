<?php

namespace Runroom\BaseBundle\Form\Type;

use Sonata\MediaBundle\Form\Type\MediaType;

class ImageType extends MediaType
{
    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'image_type';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
