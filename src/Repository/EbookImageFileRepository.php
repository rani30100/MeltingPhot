<?php

namespace App\Repository;

use App\Entity\EbookImageFile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EbookImageFile>
 *
 * @method EbookImageFile|null find($id, $lockMode = null, $lockVersion = null)
 * @method EbookImageFile|null findOneBy(array $criteria, array $orderBy = null)
 * @method EbookImageFile[]    findAll()
 * @method EbookImageFile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EbookImageFileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EbookImageFile::class);
    }

//    /**
//     * @return EbookImageFile[] Returns an array of EbookImageFile objects
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

//    public function findOneBySomeField($value): ?EbookImageFile
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
