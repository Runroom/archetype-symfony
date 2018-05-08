<?php

namespace Archetype\DemoBundle\Admin;

use Archetype\DemoBundle\Entity\Contact;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Form\Type\DateTimeRangePickerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ContactAdmin extends AbstractAdmin
{
    protected $datagridValues = [
        '_page' => 1,
        '_sort_order' => 'DESC',
        '_sort_by' => 'date',
    ];

    protected function configureRoutes(RouteCollection $collection): void
    {
        $collection->remove('create');
        $collection->remove('edit');
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('date', null, [
                'format' => 'd/m/Y h:i',
            ])
            ->add('name')
            ->add('email')
            ->add('subject', 'choice', [
                'choices' => \array_flip(Contact::$subjectChoices),
            ])
            ->add('type', 'choice', [
                'choices' => \array_flip(Contact::$typeChoices),
            ])
            ->add('preferences', 'choice', [
                'choices' => \array_flip(Contact::$preferenceChoices),
                'multiple' => true,
            ])
            ->add('comment')
            ->add('newsletter')
            ->add('status', 'choice', [
                'choices' => \array_flip(Contact::$statusChoices),
            ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('date', 'doctrine_orm_date_range', [
                'field_type' => DateTimeRangePickerType::class,
                'field_options' => [
                    'field_options_start' => ['format' => 'dd/MM/YYYY hh:mm'],
                    'field_options_end' => ['format' => 'dd/MM/YYYY hh:mm'],
                ],
            ])
            ->add('name')
            ->add('email')
            ->add('subject', null, [], ChoiceType::class, [
                'choices' => Contact::$subjectChoices,
            ])
            ->add('newsletter')
            ->add('status', null, [], ChoiceType::class, [
                'choices' => Contact::$statusChoices,
            ]);
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('date', null, [
                'format' => 'd/m/Y h:i',
            ])
            ->addIdentifier('name')
            ->add('email', 'email')
            ->add('subject', 'choice', [
                'choices' => \array_flip(Contact::$subjectChoices),
            ])
            ->add('newsletter')
            ->add('status', 'choice', [
                'choices' => \array_flip(Contact::$statusChoices),
                'editable' => true,
            ])
            ->add('_action', 'actions', [
                'actions' => [
                    'delete' => [],
                ],
            ]);
    }
}
