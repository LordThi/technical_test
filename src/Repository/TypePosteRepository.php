<?php

namespace App\Repository;

use App\Entity\TypePoste;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypePoste>
 */
class TypePosteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypePoste::class);
    }

    // Ajoutez ici des méthodes personnalisées
}
