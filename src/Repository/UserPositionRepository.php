<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\UserPosition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserPosition|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserPosition|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserPosition[]    findAll()
 * @method UserPosition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserPositionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserPosition::class);
    }

    // /**
    //  * @return UserPosition[] Returns an array of UserPosition objects
    //  */

    public function findByUser($value,$nextValue)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.user = :val')
            ->andWhere('u.quiz = :val1')
            ->setParameter('val1',$nextValue)
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    public function findRating($value){
    return $this->createQueryBuilder('u')
        ->andWhere('u.quiz = :val')
        ->setParameter('val', $value)
        ->addorderBy('u.result','DESC')
        ->addorderBy('u.spendedTime','ASC')
        ->getQuery()
        ->getResult()
        ;
    }
    public function findLeaders(){
        return $this->createQueryBuilder('u')
            ->select('u')
            ->leftJoin('App\Entity\UserPosition',
                'b',
                'WITH',
                'u.quiz=b.quiz AND u.result<b.result')
            ->where('b.result IS NULL')
            ->where('b.spendedTime is NULL')
            ->addOrderBy('u.quiz','ASC')
            ->addOrderBy('u.spendedTime','ASC')
            ->getQuery()
            ->getResult()
            ;
    }
    public function findUserCount(){
        return $this->createQueryBuilder('u')
            ->select('count(u)')
            ->groupBy('u.quiz')
            ->getQuery()
            ->getResult()
            ;
    }
    /*
    public function findOneBySomeField($value): ?UserPosition
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
