<?php

namespace App\Repository;

use App\Entity\ImgMaterial;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ImgMaterial>
 *
 * @method ImgMaterial|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImgMaterial|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImgMaterial[]    findAll()
 * @method ImgMaterial[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImgMaterialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImgMaterial::class);
    }

    public function save(ImgMaterial $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ImgMaterial $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ImgMaterial[] Returns an array of ImgMaterial objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ImgMaterial
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
