<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionRepository")
 * @ORM\Table(name="questions")
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Niveau")
     * @ORM\JoinColumn(nullable=false, name="niveau_id", referencedColumnName="id")
     */
    private Niveau $niveau;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypePoste")
     * @ORM\JoinColumn(nullable=false, name="type_poste_id", referencedColumnName="id")
     */
    private TypePoste $typePoste;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Quiz", inversedBy="questions")
     * @ORM\JoinColumn(name="quiz_id", referencedColumnName="id", nullable=false)
     */
    private Quiz $quiz;

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

    public function getNiveau(): Niveau
    {
        return $this->niveau;
    }

    public function setNiveau(Niveau $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getTypePoste(): TypePoste
    {
        return $this->typePoste;
    }

    public function setTypePoste(TypePoste $typePoste): self
    {
        $this->typePoste = $typePoste;

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
