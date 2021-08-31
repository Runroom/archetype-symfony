<?php

declare(strict_types=1);

namespace App\Form;

use App\Security\RolesBuilder\MatrixRolesBuilder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminRolesMatrixType extends AbstractType
{
    private MatrixRolesBuilder $rolesBuilder;

    public function __construct(MatrixRolesBuilder $rolesBuilder)
    {
        $this->rolesBuilder = $rolesBuilder;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'expanded' => true,
            'choices' => function (Options $options, $parentChoices): array {
                if (!empty($parentChoices)) {
                    return [];
                }

                $roles = $this->rolesBuilder->getRoles($options['choice_translation_domain']);
                $roles = array_keys($roles);

                return array_combine($roles, $roles);
            },
            'choice_translation_domain' => static function (Options $options, $value): ?string {
                if (true === $value) {
                    $value = $options['translation_domain'];
                }
                if (null === $value) {
                    $admin = null;

                    if (isset($options['sonata_admin'])) {
                        $admin = $options['sonata_admin'];
                    }

                    if (null === $admin && isset($options['sonata_field_description'])) {
                        $admin = $options['sonata_field_description']->getAdmin();
                    }

                    if (null !== $admin) {
                        $value = $admin->getTranslationDomain();
                    }
                }

                return $value;
            },

            'data_class' => null,
        ]);
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }

    public function getBlockPrefix(): string
    {
        return 'sonata_roles_matrix';
    }
}
