<?php

namespace Runroom\EntitiesBundle\Admin;

use Runroom\BaseBundle\Admin\BasePositionAdmin;
use Runroom\BaseBundle\Form\Type\MediaType;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class GalleryImageAdmin extends BasePositionAdmin
{
    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('image', MediaType::class, [
                'context' => 'default',
                'provider' => 'sonata.media.provider.image',
            ])
            ->add('position', HiddenType::class);
    }
}
