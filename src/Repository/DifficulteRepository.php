<?php

namespace App\Repository;

use App\Entity\Difficulte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Difficulte>
 */
class DifficulteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Difficulte::class);
    }

    // Ajoutez ici des méthodes personnalisées
}
