<?php

namespace App\Repository;

use App\Entity\Sourcepurpose;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sourcepurpose>
 *
 * @method Sourcepurpose|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sourcepurpose|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sourcepurpose[]    findAll()
 * @method Sourcepurpose[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SourcepurposeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sourcepurpose::class);
    }

    public function save(Sourcepurpose $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Sourcepurpose $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Sourcepurpose[] Returns an array of Sourcepurpose objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Sourcepurpose
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
