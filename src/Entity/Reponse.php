<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReponseRepository")
 * @ORM\Table(name="Reponse")
 */
#[ORM\Entity(repositoryClass: 'App\Repository\ReponseRepository')]
#[ORM\Table(name: 'Reponse')]
class Reponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: 'App\Entity\Question', inversedBy: 'reponses')]
    #[ORM\JoinColumn(name: 'question_id', referencedColumnName: 'id', nullable: false)]
    private Question $question;

    #[ORM\Column(type: 'text')]
    private string $texteReponse;

    #[ORM\Column(type: 'boolean')]
    private bool $isCorrect;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTexteReponse(): string
    {
        return $this->texteReponse;
    }

    public function setTexteReponse(string $texteReponse): void
    {
        $this->texteReponse = $texteReponse;
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

    public function isCorrect(): bool
    {
        return $this->isCorrect;
    }

    public function setIsCorrect(bool $isCorrect): self
    {
        $this->isCorrect = $isCorrect;

        return $this;
    }
}
