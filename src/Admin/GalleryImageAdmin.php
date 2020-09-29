<?php

namespace App\Admin;

use App\Entity\GalleryImage;
use Runroom\SortableBehaviorBundle\Admin\AbstractSortableAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\MediaBundle\Form\Type\MediaType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

/** @extends AbstractSortableAdmin<GalleryImage> */
class GalleryImageAdmin extends AbstractSortableAdmin
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
