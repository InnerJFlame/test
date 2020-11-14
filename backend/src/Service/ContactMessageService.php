<?php

declare(strict_types=1);

namespace App\Service;

use App\DBAL\Types\ContactMessageStatus;
use App\DBAL\Types\ContactMessageType;
use App\Entity\ContactMessage;
use App\Entity\ContactTheme;
use App\Repository\ContactThemeRepository;
use App\Repository\ContactMessageRepository;
use Doctrine\ORM\EntityManagerInterface;

class ContactMessageService
{
    /** @var EntityManagerInterface */
    private $em;

    /**
     * ContactMessageService constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param ContactMessage $contactMessage
     *
     * @return ContactMessage
     */
    public function createInbox(ContactMessage $contactMessage): ContactMessage
    {
        $contactMessage
            ->setStatus(ContactMessageStatus::STATUS_UNREAD)
            ->setType(ContactMessageType::TYPE_INBOX);

        $this->em->persist($contactMessage);
        $this->em->flush();

        return $contactMessage;
    }

    /**
     * @param ContactMessage $contactMessage
     *
     * @return ContactMessage
     */
    public function createOutbox(ContactMessage $contactMessage): ContactMessage
    {
        $contactMessage
            ->setStatus(ContactMessageStatus::STATUS_UNREAD)
            ->setType(ContactMessageType::TYPE_OUTBOX);

        $this->em->persist($contactMessage);
        $this->em->flush();

        return $contactMessage;
    }

    /**
     * @return array
     */
    public function getAvailableThemes(): array
    {
        return $this->getContactThemeRepository()->findBy(['enabled' => true]);
    }

    /**
     * @return array
     */
    public function getStats(): array
    {
        $contactMessages = $this->getContactMessageRepository()->findAll();

        $result = ['unread' => 0, 'open' => 0, 'solved' => 0, 'total' => 0];

        foreach ($contactMessages as $contactMessage) {
            if ($contactMessage->equalStatus(ContactMessageStatus::STATUS_UNREAD)) {
                $result['unread'] += 1;
            }
            if ($contactMessage->equalStatus(ContactMessageStatus::STATUS_OPEN)) {
                $result['open'] += 1;
            }
            if ($contactMessage->equalStatus(ContactMessageStatus::STATUS_SOLVED)) {
                $result['solved'] += 1;
            }
            $result['total'] += 1;
        }

        return $result;
    }

    /**
     * @return ContactThemeRepository
     */
    private function getContactThemeRepository(): ContactThemeRepository
    {
        return $this->em->getRepository(ContactTheme::class);
    }

    /**
     * @return ContactMessageRepository
     */
    private function getContactMessageRepository(): ContactMessageRepository
    {
        return $this->em->getRepository(ContactMessage::class);
    }
}
