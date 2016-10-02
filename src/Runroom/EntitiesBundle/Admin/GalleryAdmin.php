<?php

namespace Runroom\EntitiesBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;

class GalleryAdmin extends AbstractAdmin
{
    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('gallery_images', 'sonata_type_collection', [
                'label' => '(Guardar de uno en uno)',
                'by_reference' => false,
            ], [
                'edit' => 'inline',
                'inline' => 'standard',
                'sortable' => 'position',
            ])
        ;
    }
}
