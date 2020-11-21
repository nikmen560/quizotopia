<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\QuizUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method QuizUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuizUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuizUser[]    findAll()
 * @method QuizUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuizUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuizUser::class);
    }

    // /**
    //  * @return QuizUser[] Returns an array of QuizUser objects
    //  */

    public function findByUser($value,$quizId)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.user = :val')
            ->andWhere('q.quiz= :quizId')
            ->setParameter('quizId',$quizId)
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?QuizUser
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
