<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\ModelFactory;

/**
 * @extends ModelFactory<User>
 */
final class UserFactory extends ModelFactory
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {
        parent::__construct();
    }

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

    protected function initialize(): self
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

    protected static function getClass(): string
    {
        return User::class;
    }
}
