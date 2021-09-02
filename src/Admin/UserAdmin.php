<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\User;
use App\Form\AdminRolesMatrixType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/** @extends AbstractAdmin<User> */
class UserAdmin extends AbstractAdmin
{
    private ?UserPasswordHasherInterface $passwordHasher = null;

    public function setPasswordHasher(UserPasswordHasherInterface $passwordHasher): void
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function configureExportFields(): array
    {
        return array_filter(parent::configureExportFields(), static function ($field) {
            return !\in_array($field, ['password', 'salt'], true);
        });
    }

    public function prePersist(object $object): void
    {
        $this->updatePassword($object);

        $object->setCreatedAt(new \DateTimeImmutable());
    }

    public function preUpdate(object $object): void
    {
        $this->updatePassword($object);
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('email')
            ->add('enabled');
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('createdAt')
            ->addIdentifier('email')
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

    protected function configureFormFields(FormMapper $form): void
    {
        $user = $this->getSubject();

        $form
            ->with('General', [
                'class' => 'col-md-4',
                'box_class' => 'box box-solid box-primary',
            ])
                ->add('email')
                ->add('plainPassword', TextType::class, [
                    'required' => null === $user->getId(),
                    'mapped' => false,
                ])
                ->add('enabled')
            ->end()
            ->with('Roles', [
                'class' => 'col-md-8',
                'box_class' => 'box box-solid box-primary',
            ])
                ->add('roles', AdminRolesMatrixType::class, [
                    'label' => false,
                    'required' => false,
                    'expanded' => true,
                    'multiple' => true,
                ])
            ->end();
    }

    private function updatePassword(User $user): void
    {
        /** @var mixed[] */
        $submittedData = $this->getRequest()->request->get($this->getUniqId());

        if (isset($submittedData['plainPassword']) && '' !== $submittedData['plainPassword'] && null !== $this->passwordHasher) {
            $user->setPassword($this->passwordHasher->hashPassword(
                $user,
                $submittedData['plainPassword']
            ));
        }
    }
}
