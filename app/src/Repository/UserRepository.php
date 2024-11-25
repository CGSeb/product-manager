<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(
        private ManagerRegistry $registry,
        private UserPasswordHasherInterface $userPasswordHasher, /* @phpstan-ignore property.onlyWritten */
    ) {
        parent::__construct($this->registry, User::class);
    }
}
