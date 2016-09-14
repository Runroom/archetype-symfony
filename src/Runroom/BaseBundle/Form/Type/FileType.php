<?php

namespace Runroom\BaseBundle\Form\Type;

use Sonata\MediaBundle\Form\Type\MediaType;

class FileType extends MediaType
{
    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'file_type';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
