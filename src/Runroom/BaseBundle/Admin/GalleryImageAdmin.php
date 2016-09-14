<?php

namespace Runroom\BaseBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;

class GalleryImageAdmin extends BasePositionAdmin
{
    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('image', 'sonata_media_type', [
                'context' => 'default',
                'provider' => 'sonata.media.provider.image',
            ])
            ->add('featured')
            ->add('position', 'hidden')
        ;
    }
}
