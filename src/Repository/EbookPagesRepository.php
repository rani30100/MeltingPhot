<?php

namespace App\Repository;

use App\Entity\EbookPages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EbookPages>
 *
 * @method EbookPages|null find($id, $lockMode = null, $lockVersion = null)
 * @method EbookPages|null findOneBy(array $criteria, array $orderBy = null)
 * @method EbookPages[]    findAll()
 * @method EbookPages[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EbookPagesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EbookPages::class);
    }

//    /**
//     * @return EbookPages[] Returns an array of EbookPages objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?EbookPages
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
