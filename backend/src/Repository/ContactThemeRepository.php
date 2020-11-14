<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ContactTheme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ContactTheme|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContactTheme|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContactTheme[]    findAll()
 * @method ContactTheme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactThemeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContactTheme::class);
    }
}
