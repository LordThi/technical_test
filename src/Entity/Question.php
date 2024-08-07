<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionRepository")
 * @ORM\Table(name="Question")
 */
#[ORM\Entity(repositoryClass: 'App\Repository\QuestionRepository')]
#[ORM\Table(name: 'Question')]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id', type: 'integer')]
    #[Groups(['question:read', 'question:write'])]
    private int $id;

    #[ORM\Column(name: 'texte_question', type: 'string', length: 255)]
    #[Groups(['question:read', 'question:write'])]
    private string $texteQuestion;

    #[ORM\ManyToOne(targetEntity: 'App\Entity\Difficulte')]
    #[ORM\JoinColumn(name: 'difficulte_id', referencedColumnName: 'id', nullable: false)]
    #[Groups(['question:read', 'question:write'])]
    private Difficulte $difficulte;

    #[ORM\ManyToOne(targetEntity: 'App\Entity\Quiz', inversedBy: 'questions')]
    #[ORM\JoinColumn(name: 'quiz_id', referencedColumnName: 'id', nullable: false)]
    #[Groups(['question:read', 'question:write'])]
    private Quiz $quiz;

    #[ORM\ManyToOne(targetEntity: 'App\Entity\ThemeQuestion')]
    #[ORM\JoinColumn(name: 'theme_id', referencedColumnName: 'id', nullable: false)]
    #[Groups(['question:read', 'question:write'])]
    private ThemeQuestion $themeQuestion;

    #[ORM\ManyToOne(targetEntity: 'App\Entity\TypeQuestion')]
    #[ORM\JoinColumn(name: 'type_id', referencedColumnName: 'id', nullable: false)]
    #[Groups(['question:read', 'question:write'])]
    private TypeQuestion $typeQuestion;

    #[ORM\OneToMany(targetEntity: 'App\Entity\Reponse', mappedBy: 'question')]
    #[Groups(['question:read'])]
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

    public function getThemeQuestion(): ThemeQuestion
    {
        return $this->themeQuestion;
    }

    public function setThemeQuestion(ThemeQuestion $themeQuestion): self
    {
        $this->themeQuestion = $themeQuestion;

        return $this;
    }

    public function getTypeQuestion(): TypeQuestion
    {
        return $this->typeQuestion;
    }

    public function setTypeQuestion(TypeQuestion $typeQuestion): self
    {
        $this->typeQuestion = $typeQuestion;

        return $this;
    }

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
