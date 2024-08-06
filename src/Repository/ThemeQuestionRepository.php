<?php

namespace App\Repository;

use App\Entity\ThemeQuestion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ThemeQuestion>
 */
class ThemeQuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ThemeQuestion::class);
    }

    // Ajoutez ici des méthodes personnalisées
}
