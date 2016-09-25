<?php

namespace Runroom\BaseBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;

class EntityMetaInformationAdmin extends AbstractAdmin
{
    public function validate(ErrorElement $errorElement, $object)
    {
        $errorElement
            ->with('translations')->assertValid()->end()
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Translations', [
                'box_class' => 'box box-solid box-primary',
            ])
                ->add('translations', 'a2lix_translations', [
                    'cascade_validation' => true,
                    'fields' => [
                        'title' => [
                            'required' => false,
                        ],
                        'description' => [
                            'required' => false,
                        ],
                    ],
                ])
            ->end()
        ;
    }
}
