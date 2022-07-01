<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\Form\Type\DatePickerType;
use Sonata\Form\Type\DateTimePickerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

/**
 * @phpstan-extends AbstractAdmin<\Sonata\UserBundle\Model\UserInterface>
 */
class UserAdmin extends AbstractAdmin
{
    protected $baseRoutePattern = 'asda';
    protected $baseRouteName = 'asda';

    protected function configureListFields(ListMapper $list): void
    {
        $list->addIdentifier('id');
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('normal_datepicker', DatePickerType::class, [
                'mapped' => false,
                'datepicker_options' => [
                    'allowInput' => false,
                    'disable' => [new \DateTime('tomorrow')],
                ],
            ])
            ->add('normal_datetimepicker', DateTimePickerType::class, [
                'mapped' => false,
                'datepicker_options' => [
                    'allowInput' => false,
                    'disable' => [new \DateTime('tomorrow')],
                ],
            ])
            ->add('symfony_date', DateType::class, [
                'mapped' => false,
                'widget' => 'single_text',
            ])
            ->add('symfony_datetime', DateTimeType::class, [
                'mapped' => false,
                'widget' => 'single_text',
                'with_seconds' => true,
            ]);
    }
}
