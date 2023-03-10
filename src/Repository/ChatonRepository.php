<?php

namespace App\Repository;

use App\Entity\Chaton;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Chaton>
 *
 * @method Chaton|null find($id, $lockMode = null, $lockVersion = null)
 * @method Chaton|null findOneBy(array $criteria, array $orderBy = null)
 * @method Chaton[]    findAll()
 * @method Chaton[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChatonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Chaton::class);
    }

    public function add(Chaton $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Chaton $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}