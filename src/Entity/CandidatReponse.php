<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="CandidatReponses")
 * @ORM\Entity(repositoryClass="App\Repository\CandidatReponseRepository")
 */
class CandidatReponse
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity="Candidat")
     * @ORM\JoinColumn(nullable=false, name="candidat_id", referencedColumnName="id")
     */
    private Candidat $candidat;

    /**
     * @ORM\ManyToOne(targetEntity="Question")
     * @ORM\JoinColumn(nullable=false, name="question_id", referencedColumnName="id")
     */
    private Question $question;

    /**
     * @ORM\ManyToOne(targetEntity="Reponse")
     * @ORM\JoinColumn(nullable=false, name="reponse_id", referencedColumnName="id")
     */
    private Reponse $reponse;

    /**
     * @ORM\Column(type="integer")
     */
    private int $tempsReponse;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return Candidat
     */
    public function getCandidat(): Candidat
    {
        return $this->candidat;
    }

    /**
     * @param Candidat $candidat
     */
    public function setCandidat(Candidat $candidat): void
    {
        $this->candidat = $candidat;
    }

    /**
     * @return Question
     */
    public function getQuestion(): Question
    {
        return $this->question;
    }

    /**
     * @param Question $question
     */
    public function setQuestion(Question $question): void
    {
        $this->question = $question;
    }

    /**
     * @return Reponse
     */
    public function getReponse(): Reponse
    {
        return $this->reponse;
    }

    /**
     * @param Reponse $reponse
     */
    public function setReponse(Reponse $reponse): void
    {
        $this->reponse = $reponse;
    }

    /**
     * @return int
     */
    public function getTempsReponse(): int
    {
        return $this->tempsReponse;
    }

    /**
     * @param int $tempsReponse
     */
    public function setTempsReponse(int $tempsReponse): void
    {
        $this->tempsReponse = $tempsReponse;
    }


}
