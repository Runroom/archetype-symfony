<?php

declare(strict_types=1);

namespace App\Model;

use Sonata\AdminBundle\FieldDescription\BaseFieldDescription;

final class FieldDescription extends BaseFieldDescription
{
    public function setAssociationMapping($associationMapping): void
    {
    }

    public function getTargetEntity(): ?string
    {
        return null;
    }

    public function getTargetModel(): ?string
    {
        return null;
    }

    public function setFieldMapping(array $fieldMapping): void
    {
    }

    public function setParentAssociationMappings(array $parentAssociationMappings): void
    {
    }

    public function isIdentifier(): bool
    {
        return false;
    }

    public function getValue(object $object)
    {
        return $this->getFieldValue($object, $this->fieldName);
    }

    public function describesSingleValuedAssociation(): bool
    {
        return false;
    }

    public function describesCollectionValuedAssociation(): bool
    {
        return false;
    }
}
