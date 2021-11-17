<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;

class FooPictureAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'admin_page_product_picture';
    protected $baseRoutePattern = 'site-product-picture';

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('image', ModelListType::class, [
                'required' => false
            ], [
                'link_parameters' => ['context' => 'default']
            ]);
    }
}
