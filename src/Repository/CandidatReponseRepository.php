<?php

namespace App\Repository;

use App\Entity\CandidatReponse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CandidatReponse>
 */
class CandidatReponseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CandidatReponse::class);
    }

    // Ajoutez ici des méthodes personnalisées
}
