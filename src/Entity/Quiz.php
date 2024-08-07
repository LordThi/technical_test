<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="Quiz")
 * @ORM\Entity(repositoryClass="App\Repository\QuizRepository")
 */
#[ORM\Entity(repositoryClass: 'App\Repository\QuizRepository')]
#[ORM\Table(name: 'Quiz')]
class Quiz
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['quiz:read'])]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['quiz:read', 'quiz:write'])]
    private string $titre;

    #[ORM\Column(name: 'temps_max', type: 'integer')]
    #[Assert\GreaterThan(0)]
    #[Groups(['quiz:read','quiz:write'])]
    private int $tempsMax;

    #[ORM\OneToMany(targetEntity: 'App\Entity\Question', mappedBy: 'quiz')]
    #[Groups(['quiz:read'])]
    private Collection $questions;

    #[ORM\Column(name: 'nombre_questions', type: 'integer')]
    #[Groups(['quiz:read','quiz:write'])]
    private int $nombreQuestions;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getTempsMax(): ?int
    {
        return $this->tempsMax;
    }

    public function setTempsMax(int $tempsMax): self
    {
        $this->tempsMax = $tempsMax;

        return $this;
    }

    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions[] = $question;
            $question->setQuiz($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->contains($question)) {
            $this->questions->removeElement($question);
            // set the owning side to null (unless already changed)
            if ($question->getQuiz() === $this) {
                $question->setQuiz(null);
            }
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getNombreQuestions(): int
    {
        return $this->nombreQuestions;
    }

    /**
     * @param int $nombreQuestions
     */
    public function setNombreQuestions(int $nombreQuestions): void
    {
        $this->nombreQuestions = $nombreQuestions;
    }
}
