<?php


namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="Quiz")
 * @ORM\Entity(repositoryClass="App\Repository\QuizRepository")
 */
class Quiz
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private string $titre;

    /**
     * @ORM\Column(type="integer", name="temps_max")
     * @Assert\GreaterThan(0)
     */
    private int $tempsMax;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Question", mappedBy="quiz")
     */
    private Collection $questions;

    /**
     * @ORM\Column (name="nombre_questions", type="int")
     */
    private int $nombreQuestions;

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

    public function getDifficulte(): Difficulte
    {
        return $this->difficulte;
    }

    public function setDifficulte($difficulte): self
    {
        $this->difficulte = $difficulte;

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
}

