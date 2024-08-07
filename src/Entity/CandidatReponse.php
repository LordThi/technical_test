<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: 'App\Repository\CandidatReponseRepository')]
#[ORM\Table(name: 'CandidatReponse')]
class CandidatReponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Candidat::class)]
    #[ORM\JoinColumn(name: 'candidat_id', referencedColumnName: 'id', nullable: false)]
    private Candidat $candidat;

    #[ORM\ManyToOne(targetEntity: Question::class)]
    #[ORM\JoinColumn(name: 'question_id', referencedColumnName: 'id', nullable: false)]
    private Question $question;

    #[ORM\ManyToOne(targetEntity: Reponse::class)]
    #[ORM\JoinColumn(name: 'reponse_id', referencedColumnName: 'id', nullable: false)]
    private Reponse $reponse;

    #[ORM\Column(name: 'date_reponse', type: 'datetime')]
    private \DateTime $dateReponse;

    #[ORM\Column(name: 'sortie_ecran', type: 'boolean')]
    private bool $sortieEcran;

    public function isSortieEcran(): bool
    {
        return $this->sortieEcran;
    }

    public function setSortieEcran(bool $sortieEcran): self
    {
        $this->sortieEcran = $sortieEcran;
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getCandidat(): Candidat
    {
        return $this->candidat;
    }

    public function setCandidat(Candidat $candidat): self
    {
        $this->candidat = $candidat;
        return $this;
    }

    public function getQuestion(): Question
    {
        return $this->question;
    }

    public function setQuestion(Question $question): self
    {
        $this->question = $question;
        return $this;
    }

    public function getReponse(): Reponse
    {
        return $this->reponse;
    }

    public function setReponse(Reponse $reponse): self
    {
        $this->reponse = $reponse;
        return $this;
    }

    public function getDateReponse(): \DateTime
    {
        return $this->dateReponse;
    }

    public function setDateReponse(\DateTime $dateReponse): self
    {
        $this->dateReponse = $dateReponse;
        return $this;
    }
}
