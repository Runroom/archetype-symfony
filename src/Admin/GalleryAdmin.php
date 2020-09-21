<?php

namespace App\Admin;

use App\Entity\Gallery;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\Form\Type\CollectionType;

/** @phpstan-extends AbstractAdmin<Gallery> */
class GalleryAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->add('galleryImages', CollectionType::class, [
                'by_reference' => false,
            ], [
                'edit' => 'inline',
                'inline' => 'standard',
                'sortable' => 'position',
            ]);
    }
}
