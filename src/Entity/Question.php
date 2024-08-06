<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionRepository")
 * @ORM\Table(name="Question")
 */
class Question
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id", type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(name="texte_question", type="string", length=255)
     */
    private string $texteQuestion;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Difficulte")
     * @ORM\JoinColumn(nullable=false, name="difficulte_id", referencedColumnName="id")
     */
    private Difficulte $difficulte;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Quiz", inversedBy="questions")
     * @ORM\JoinColumn(name="quiz_id", referencedColumnName="id", nullable=false)
     */
    private Quiz $quiz;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ThemeQuestion")
     * @ORM\JoinColumn(name="theme_id", referencedColumnName="id", nullable=false)
     */
    private ThemeQuestion $themeQuestion;

    /**
     * @return ThemeQuestion
     */
    public function getThemeQuestion(): ThemeQuestion
    {
        return $this->themeQuestion;
    }

    /**
     * @param ThemeQuestion $themeQuestion
     */
    public function setThemeQuestion(ThemeQuestion $themeQuestion): void
    {
        $this->themeQuestion = $themeQuestion;
    }

    /**
     * @return TypeQuestion
     */
    public function getTypeQuestion(): TypeQuestion
    {
        return $this->typeQuestion;
    }

    /**
     * @param TypeQuestion $typeQuestion
     */
    public function setTypeQuestion(TypeQuestion $typeQuestion): void
    {
        $this->typeQuestion = $typeQuestion;
    }

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeQuestion")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id", nullable=false)
     */
    private TypeQuestion $typeQuestion;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reponse", mappedBy="question")
     */
    private Collection $reponses;

    public function __construct()
    {
        $this->reponses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTexteQuestion(): ?string
    {
        return $this->texteQuestion;
    }

    public function setTexteQuestion(string $texteQuestion): self
    {
        $this->texteQuestion = $texteQuestion;

        return $this;
    }

    public function getDifficulte(): Difficulte
    {
        return $this->difficulte;
    }

    public function setDifficulte(Difficulte $difficulte): self
    {
        $this->difficulte = $difficulte;

        return $this;
    }

    public function getQuiz(): Quiz
    {
        return $this->quiz;
    }

    public function setQuiz(Quiz $quiz): self
    {
        $this->quiz = $quiz;

        return $this;
    }

    /**
     * @return Collection|Reponse[]
     */
    public function getReponses(): Collection
    {
        return $this->reponses;
    }

    public function addReponse(Reponse $reponse): self
    {
        if (!$this->reponses->contains($reponse)) {
            $this->reponses[] = $reponse;
            $reponse->setQuestion($this);
        }

        return $this;
    }

    public function removeReponse(Reponse $reponse): self
    {
        if ($this->reponses->contains($reponse)) {
            $this->reponses->removeElement($reponse);
            if ($reponse->getQuestion() === $this) {
                $reponse->setQuestion(null);
            }
        }

        return $this;
    }
}
