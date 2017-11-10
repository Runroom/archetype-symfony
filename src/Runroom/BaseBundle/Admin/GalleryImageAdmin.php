<?php

namespace Runroom\BaseBundle\Admin;

use Runroom\BaseBundle\Form\Type\MediaType;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class GalleryImageAdmin extends BasePositionAdmin
{
    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->add('image', MediaType::class, [
                'context' => 'default',
                'provider' => 'sonata.media.provider.image',
            ])
            ->add('position', HiddenType::class);
    }
}
