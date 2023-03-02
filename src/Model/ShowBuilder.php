<?php

declare(strict_types=1);

namespace App\Model;

use Sonata\AdminBundle\Builder\ShowBuilderInterface;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionCollection;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Templating\TemplateRegistryInterface;

final class ShowBuilder implements ShowBuilderInterface
{
    public function fixFieldDescription(FieldDescriptionInterface $fieldDescription): void
    {
        if (null === $fieldDescription->getTemplate()) {
            $fieldDescription->setTemplate($this->getTemplate($fieldDescription->getType()));
        }
    }

    public function getBaseList(array $options = []): FieldDescriptionCollection
    {
        return new FieldDescriptionCollection();
    }

    public function addField(FieldDescriptionCollection $list, ?string $type, FieldDescriptionInterface $fieldDescription): void
    {
        $fieldDescription->setType($type);
        $this->fixFieldDescription($fieldDescription);

        $list->add($fieldDescription);
    }

    private function getTemplate(?string $type): ?string
    {
        return TemplateRegistryInterface::SHOW_TEMPLATES[$type] ?? null;
    }
}
