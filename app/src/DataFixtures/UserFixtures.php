<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = (new User())
            ->setEmail('test@test.fr')
            ->setPassword('$2y$13$4WIKGhQeHBV3ctAcxvABtuw2k6tRbbgi34tcq.LB9ylUdyap3LZk6');
        $manager->persist($user);

        $manager->flush();
    }
}
