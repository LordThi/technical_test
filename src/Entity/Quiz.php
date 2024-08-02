<?php


namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Difficulte")
     * @ORM\JoinColumn(name="difficulte_id", referencedColumnName="id", nullable=false)
     */
    private Difficulte $difficulte;


    /**
     * @ORM\Column(type="integer")
     * @Assert\GreaterThan(0)
     */
    private int $tempsAlloue;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Question", mappedBy="quiz")
     */
    private Collection $questions;

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

    public function getTempsAlloue(): ?int
    {
        return $this->tempsAlloue;
    }

    public function setTempsAlloue(int $tempsAlloue): self
    {
        $this->tempsAlloue = $tempsAlloue;

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

