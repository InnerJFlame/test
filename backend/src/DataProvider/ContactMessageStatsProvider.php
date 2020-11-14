<?php

declare(strict_types=1);

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\ContactMessageStats;
use App\Service\ContactMessageService;
use DateTime;

class ContactMessageStatsProvider implements CollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private $contactMessageService;

    /**
     * ContactMessageStatsProvider constructor.
     *
     * @param ContactMessageService $contactMessageService
     */
    public function __construct(ContactMessageService $contactMessageService)
    {
        $this->contactMessageService = $contactMessageService;
    }

    /**
     * @param string      $resourceClass
     * @param string|null $operationName
     *
     * @return ContactMessageStats[]|iterable
     */
    public function getCollection(string $resourceClass, string $operationName = null)
    {
        $data = $this->contactMessageService->getStats();
        $stats = new ContactMessageStats(new DateTime(), $data['total'], $data['open'], $data['unread'], $data['solved']);

        return [$stats];
    }

    /**
     * @param string      $resourceClass
     * @param string|null $operationName
     * @param array       $context
     *
     * @return bool
     */
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return $resourceClass === ContactMessageStats::class;
    }
}
