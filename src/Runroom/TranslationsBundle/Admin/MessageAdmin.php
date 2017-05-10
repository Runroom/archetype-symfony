<?php

namespace Runroom\TranslationsBundle\Admin;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Validator\Constraints as Assert;

class MessageAdmin extends AbstractAdmin
{
    protected $datagridValues = [
        '_page' => 1,
        '_sort_order' => 'ASC',
        '_sort_by' => 'key',
    ];

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('key')
            ->add('translations.value', null, ['label' => 'Value']);
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('create');
        $collection->remove('delete');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('key')
            ->add('value', 'html', [
                'sortable' => true,
                'sort_field_mapping' => ['fieldName' => 'value'],
                'sort_parent_association_mappings' => [['fieldName' => 'translations']],
            ]);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('key')
            ->add('translations', TranslationsType::class, [
                'label' => false,
                'required' => false,
                'fields' => [
                    'value' => [
                        'field_type' => CKEditorType::class,
                        'config_name' => 'messages',
                    ],
                ],
                'constraints' => [
                    new Assert\Valid(),
                ],
            ]);
    }
}
