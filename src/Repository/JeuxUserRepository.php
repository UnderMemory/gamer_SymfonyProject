<?php

namespace App\Repository;

use App\Entity\Jeux;
use App\Entity\JeuxUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method JeuxUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method JeuxUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method JeuxUser[]    findAll()
 * @method JeuxUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JeuxUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JeuxUser::class);
    }

    public function findJeuxByIdUser($idUser){
        return $this->createQueryBuilder('j')
            ->select('jm.nom, jm.description, jm.photo', 'jm.id', 'j.note')
            ->leftJoin('j.id_jeux', "jm")
            ->andWhere('j.id_user = :idUser')
            ->setParameter('idUser', $idUser)
            ->getQuery()
            ->getResult();
    }
    // /**
    //  * @return JeuxUser[] Returns an array of JeuxUser objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('j.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?JeuxUser
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
