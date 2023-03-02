<?php

declare(strict_types=1);

namespace App\Model;

use Sonata\AdminBundle\FieldDescription\FieldDescriptionFactoryInterface;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;

final class FieldDescriptionFactory implements FieldDescriptionFactoryInterface
{
    public function create(string $class, string $name, array $options = []): FieldDescriptionInterface
    {
        return new FieldDescription($name, $options);
    }
}
