<?php

namespace Runroom\EntitiesBundle\Admin;

use Runroom\BaseBundle\Admin\BasePositionAdmin;
use Sonata\AdminBundle\Form\FormMapper;

class GalleryImageAdmin extends BasePositionAdmin
{
    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('image', 'media_type', [
                'context' => 'default',
                'provider' => 'sonata.media.provider.image',
            ])
            ->add('position', 'hidden')
        ;
    }
}
