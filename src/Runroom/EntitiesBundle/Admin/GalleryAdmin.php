<?php

namespace Runroom\EntitiesBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Form\Type\CollectionType;

class GalleryAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('galleryImages', CollectionType::class, [
                'label' => '(Save one by one)',
                'by_reference' => false,
            ], [
                'edit' => 'inline',
                'inline' => 'standard',
                'sortable' => 'position',
            ]);
    }
}
