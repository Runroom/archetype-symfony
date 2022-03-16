<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\User;
use Zenstruck\Foundry\ModelFactory;

/**
 * @extends ModelFactory<User>
 */
final class UserFactory extends ModelFactory
{
    /**
     * @return array<string, mixed>
     */
    protected function getDefaults(): array
    {
        return [
            'username' => static::faker()->unique()->email(),
            'email' => static::faker()->unique()->email(),
            'password' => static::faker()->password(),
            'enabled' => static::faker()->boolean(),
            'roles' => [],
        ];
    }

    protected static function getClass(): string
    {
        return User::class;
    }
}
