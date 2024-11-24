<?php

declare(strict_types=1);

namespace App\Tests\Application\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserTest extends WebTestCase
{
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $passwordHasher;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->entityManager = self::getContainer()->get(EntityManagerInterface::class);
        $this->passwordHasher = self::getContainer()->get(UserPasswordHasherInterface::class);
    }

    public function testCreateUser(): void
    {
        $user = new User();
        $user->setEmail('testuser@example.com');
        $user->setRoles(['ADMIN']);
        $password = 'password123';

        $hashedPassword = $this->passwordHasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        /** @var User $foundUser */
        $foundUser = $this->entityManager->getRepository(User::class)->findOneBy(['email' => 'testuser@example.com']);
        
        $this->assertNotNull($foundUser);
        $this->assertEquals('testuser@example.com', $foundUser->getEmail());
        $this->assertEquals(['ADMIN', 'ROLE_USER'], $foundUser->getRoles());
        $this->assertNotNull($foundUser->getId());
        $this->assertTrue(password_verify($password, $foundUser->getPassword()));
    }

    public function tearDown(): void
    {
        parent::tearDown();

        restore_exception_handler();
    }
}