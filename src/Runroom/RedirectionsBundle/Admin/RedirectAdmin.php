<?php

namespace Runroom\RedirectionsBundle\Admin;

use Runroom\RedirectionsBundle\Entity\Redirect;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RedirectAdmin extends AbstractAdmin
{
    protected static $typeChoices = [
        'redirect.httpCode.permanent' => Redirect::PERMANENT,
        'redirect.httpCode.temporal' => Redirect::TEMPORAL,
    ];

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('source')
            ->add('destination')
            ->add('httpCode', null, [], ChoiceType::class, [
                'choices' => self::$typeChoices,
            ])
            ->add('publish');
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('source', 'url', [
                'hide_protocol' => true,
                'attributes' => [
                    'target' => '_blank',
                ],
            ])
            ->add('destination', 'url', [
                'hide_protocol' => true,
                'attributes' => [
                    'target' => '_blank',
                ],
            ])
            ->add('httpCode', 'choice', [
                'choices' => \array_flip(self::$typeChoices),
                'editable' => true,
                'catalogue' => 'messages',
            ])
            ->add('publish', null, [
                'editable' => true,
            ])
            ->add('_action', null, [
                'actions' => [
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->add('source', null, [
                'help' => 'redirect.source',
            ])
            ->add('destination', null, [
                'help' => 'redirect.destination',
            ])
            ->add('httpCode', ChoiceType::class, [
                'choices' => self::$typeChoices,
                'label' => false,
                'expanded' => true,
            ])
            ->add('publish');
    }
}
