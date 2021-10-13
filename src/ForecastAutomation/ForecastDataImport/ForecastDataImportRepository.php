<?php

namespace ForecastAutomation\ForecastDataImport;

use ForecastAutomation\ForecastDataImport\Shared\Entity\FcImportState;
use Doctrine\Persistence\ManagerRegistry;
use ForecastAutomation\Kernel\AbstractRepository;

/**
 * @method FcImportState|null find($id, $lockMode = null, $lockVersion = null)
 * @method FcImportState|null findOneBy(array $criteria, array $orderBy = null)
 * @method FcImportState[]    findAll()
 * @method FcImportState[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ForecastDataImportRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FcImportState::class);
    }

    // /**
    //  * @return FcImportState[] Returns an array of FcImportState objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FcImportState
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
