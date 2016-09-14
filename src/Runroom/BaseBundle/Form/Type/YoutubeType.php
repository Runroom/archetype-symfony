<?php

namespace Runroom\BaseBundle\Form\Type;

use Sonata\MediaBundle\Form\Type\MediaType;

class YoutubeType extends MediaType
{
    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'youtube_type';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
