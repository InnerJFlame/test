<?php

declare(strict_types=1);

namespace App\Service;

use App\DBAL\Types\UserStatus;
use App\Entity\User;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class SecurityService
{
    private $passwordEncoder;

    private $em;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $em)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->em = $em;
    }

    /**
     * @param User $user
     *
     * @return User
     */
    public function register(User $user): User
    {
        $user
            ->setPassword($this->passwordEncoder->encodePassword($user, $user->getPlainPassword()))
            ->setStatus(UserStatus::STATUS_WAITING);
        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    /**
     * @param string $token
     *
     * @return User
     */
    public function confirmRegistration(string $token): User
    {
        $user = $this->getUserRepository()->findOneBy(['token' => $token]);

        if (!$user) {
            throw new BadRequestHttpException();
        }

        $user->setStatus(UserStatus::STATUS_CONFIRMED);
        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    /**
     * @param UserInterface $user
     * @param string        $plainPassword
     */
    public function changePassword(UserInterface $user, string $plainPassword): void
    {
        $user->setPassword($this->passwordEncoder->encodePassword($user, $plainPassword));
        $this->em->persist($user);
        $this->em->flush();
    }

    /**
     * @param UserInterface|User $user
     * @param string             $email
     */
    public function changeEmail(UserInterface $user, string $email): void
    {
        $user->setNewEmail($email);
        $this->em->persist($user);
        $this->em->flush();
    }

    /**
     * @param string $token
     */
    public function confirmChangeEmail(string $token): void
    {
        $user = $this->getUserRepository()->findOneBy(['token' => $token]);

        if (!$user) {
            throw new BadRequestHttpException();
        }

        $user->setEmail($user->getNewEmail());
        $user->setNewEmail(null);
        $this->em->persist($user);
        $this->em->flush();
    }

    /**
     * @param UserInterface|User $user
     */
    public function deleteAccount(UserInterface $user): void
    {
        $user->setDeletedAt(new DateTime());
        $this->em->persist($user);
        $this->em->flush();
    }

    /**
     * @return UserRepository
     */
    private function getUserRepository(): UserRepository
    {
        return $this->em->getRepository(User::class);
    }
}
