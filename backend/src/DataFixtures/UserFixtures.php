<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\DBAL\Types\UserRole;
use App\DBAL\Types\UserStatus;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $admin = (new User())
            ->setEmail('admin@gmail.com')
            ->setName('admin')
            ->setRoles([UserRole::ROLE_ADMIN])
            ->setAge(25)
            ->setStatus(UserStatus::STATUS_CONFIRMED);
        $admin->setPassword($this->passwordEncoder->encodePassword($admin, 'qweqwe'));
        $manager->persist($admin);

        $client = (new User())
            ->setEmail('client@gmail.com')
            ->setName('client')
            ->setRoles([UserRole::ROLE_CLIENT])
            ->setAge(25)
            ->setStatus(UserStatus::STATUS_CONFIRMED);
        $client->setPassword($this->passwordEncoder->encodePassword($client, 'qweqwe'));
        $manager->persist($client);

        $escort = (new User())
            ->setEmail('escort@gmail.com')
            ->setName('escort')
            ->setRoles([UserRole::ROLE_ESCORT])
            ->setAge(25)
            ->setStatus(UserStatus::STATUS_CONFIRMED);
        $escort->setPassword($this->passwordEncoder->encodePassword($escort, 'qweqwe'));
        $manager->persist($escort);

        $manager->flush();
    }
}
