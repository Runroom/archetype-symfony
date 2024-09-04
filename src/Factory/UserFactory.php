<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\Persistence\PersistentObjectFactory;

/**
 * @extends PersistentObjectFactory<User>
 */
final class UserFactory extends PersistentObjectFactory
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
        parent::__construct();
    }

    public static function class(): string
    {
        return User::class;
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaults(): array
    {
        return [
            'username' => static::faker()->unique()->email(),
            'email' => static::faker()->unique()->email(),
            'password' => static::faker()->password(),
            'enabled' => static::faker()->boolean(),
            'roles' => [],
        ];
    }

    protected function initialize(): static
    {
        return $this->afterInstantiate(function (User $user) {
            $plainPassword = $user->getPassword();

            if (null !== $plainPassword) {
                $user->setPassword($this->passwordHasher->hashPassword(
                    $user,
                    $plainPassword
                ));
            }
        });
    }
}
