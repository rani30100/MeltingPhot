<?php

namespace App\Repository;

use App\Entity\Ebook;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ebook>
 *
 * @method Ebook|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ebook|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ebook[]    findAll()
 * @method Ebook[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EbookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ebook::class);
    }

    public function findByQuery($query)
    {
        // Check if the query contains specific keywords
        $keywords = ['magazine', 'livre', 'livre numérique', 'flipbook', 'ebook'];
        $isSpecialQuery = false;
    
        foreach ($keywords as $keyword) {
            if (strpos(strtolower($query), $keyword) !== false) {
                $isSpecialQuery = true;
                break;
            }
        }
    
        $qb = $this->createQueryBuilder('e');
    
        // If it's a special query, return all ebooks
        if ($isSpecialQuery) {
            return $qb->getQuery()->getResult();
        }
    
        // If not, search for ebooks with titles containing the query
        return $qb
            ->where('e.title LIKE :query')
            ->setParameter('query', '%' . $query . '%')
            ->getQuery()
            ->getResult();
    }
    

    //    /**
    //     * @return Ebook[] Returns an array of Ebook objects
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

//    public function findOneBySomeField($value): ?Ebook
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
