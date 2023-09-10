<?php

namespace App\Repository;

use App\Entity\EbookImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EbookImage>
 *
 * @method EbookImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method EbookImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method EbookImage[]    findAll()
 * @method EbookImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EbookImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EbookImage::class);
    }

//    /**
//     * @return EbookImage[] Returns an array of EbookImage objects
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

//    public function findOneBySomeField($value): ?EbookImage
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
