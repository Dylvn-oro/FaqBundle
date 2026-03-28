<?php

declare(strict_types=1);

namespace Dylvn\Bundle\FaqBundle\Entity\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Dylvn\Bundle\FaqBundle\Entity\Category;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[] findAll()
 * @method Category[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    /**
     * @return Category[]
     */
    public function findVisibleOnFaqPage(): array
    {
        return $this->createQueryBuilder('c')
            ->where('c.enabled = :enabled')
            ->andWhere('c.visibleOnFaqPage = :visible')
            ->setParameter('enabled', true)
            ->setParameter('visible', true)
            ->orderBy('c.position', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
