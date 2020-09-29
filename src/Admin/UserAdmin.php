<?php

namespace App\Admin;

use App\Entity\User;
use FOS\UserBundle\Model\UserManagerInterface;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\UserBundle\Form\Type\RolesMatrixType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/** @extends AbstractAdmin<User> */
class UserAdmin extends AbstractAdmin
{
    /** @var UserManagerInterface */
    private $userManager;

    public function setUserManager(UserManagerInterface $userManager): void
    {
        $this->userManager = $userManager;
    }

    public function getExportFields()
    {
        return array_filter(parent::getExportFields(), static function ($field) {
            return !\in_array($field, ['password', 'salt'], true);
        });
    }

    public function preUpdate($user): void
    {
        $this->userManager->updateCanonicalFields($user);
        $this->userManager->updatePassword($user);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('username')
            ->add('email')
            ->add('enabled');
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('createdAt')
            ->addIdentifier('username')
            ->add('email')
            ->add('enabled', null, [
                'editable' => true,
            ])
            ->add('_action', 'actions', [
                'translation_domain' => 'messages',
                'actions' => [
                    'delete' => [],
                    'impersonate' => [
                        'template' => 'sonata/impersonate_user.html.twig',
                    ],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $user = $this->getSubject();

        $formMapper
            ->with('General', [
                'class' => 'col-md-4',
                'box_class' => 'box box-solid box-primary',
            ])
                ->add('username')
                ->add('email')
                ->add('plainPassword', TextType::class, [
                    'required' => !$user || $user->getId() === null,
                ])
                ->add('enabled')
            ->end()
            ->with('Roles', [
                'class' => 'col-md-8',
                'box_class' => 'box box-solid box-primary',
            ])
                ->add('realRoles', RolesMatrixType::class, [
                    'label' => false,
                    'required' => false,
                    'expanded' => true,
                    'multiple' => true,
                ])
            ->end();
    }
}
