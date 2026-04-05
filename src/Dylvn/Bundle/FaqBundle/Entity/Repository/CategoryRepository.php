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
     * @param int[] $ids
     * @return Category[]
     */
    public function findByIdsWithItems(array $ids): array
    {
        if (empty($ids)) {
            return [];
        }

        return $this->createQueryBuilder('c')
            ->addSelect('ci', 'i', 'iq', 'ia')
            ->innerJoin('c.categoryItems', 'ci')
            ->innerJoin('ci.item', 'i')
            ->leftJoin('i.questions', 'iq')
            ->leftJoin('i.answers', 'ia')
            ->where('c.id IN (:ids)')
            ->andWhere('c.enabled = :enabled')
            ->andWhere('ci.enabled = :enabled')
            ->andWhere('i.enabled = :enabled')
            ->setParameter('ids', $ids)
            ->setParameter('enabled', true)
            ->orderBy('c.position', 'ASC')
            ->addOrderBy('ci.position', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Category[]
     */
    public function findVisibleOnFaqPage(): array
    {
        return $this->createQueryBuilder('c')
            ->addSelect('ci', 'i', 'iq', 'ia')
            ->innerJoin('c.categoryItems', 'ci')
            ->innerJoin('ci.item', 'i')
            ->leftJoin('i.questions', 'iq')
            ->leftJoin('i.answers', 'ia')
            ->where('c.enabled = :enabled')
            ->andWhere('c.visibleOnFaqPage = :visible')
            ->andWhere('ci.enabled = :enabled')
            ->andWhere('i.enabled = :enabled')
            ->setParameter('enabled', true)
            ->setParameter('visible', true)
            ->orderBy('c.position', 'ASC')
            ->addOrderBy('ci.position', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
