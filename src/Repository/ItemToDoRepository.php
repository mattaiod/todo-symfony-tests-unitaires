<?php

namespace App\Repository;

use App\Entity\ItemToDo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ItemToDo|null find($id, $lockMode = null, $lockVersion = null)
 * @method ItemToDo|null findOneBy(array $criteria, array $orderBy = null)
 * @method ItemToDo[]    findAll()
 * @method ItemToDo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemToDoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ItemToDo::class);
    }
}
