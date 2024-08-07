<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CandidatRepository")
 * @ORM\Table(name="Candidats")
 */
#[ORM\Entity(repositoryClass: 'App\Repository\CandidatRepository')]
#[ORM\Table(name: 'Candidats')]
class Candidat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 100)]
    private string $nom;

    #[ORM\Column(type: 'string', length: 100)]
    private string $prenom;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private string $email;
    
    #[ORM\ManyToOne(targetEntity: 'App\Entity\Quiz')]
    #[ORM\JoinColumn(name: 'quiz_id', referencedColumnName: 'id', nullable: true)]
    private Quiz $quiz;

    #[ORM\ManyToOne(targetEntity: 'App\Entity\Niveau')]
    #[ORM\JoinColumn(name: 'niveau_id', referencedColumnName: 'id', nullable: true)]
    private Niveau $niveau;

    #[ORM\ManyToOne(targetEntity: 'App\Entity\TypePoste')]
    #[ORM\JoinColumn(name: 'type_poste_id', referencedColumnName: 'id', nullable: true)]
    private TypePoste $typePoste;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $tempsTotal; // Temps total en secondes pour compléter le quiz

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTime $datePassage; // Date et heure du passage du quiz

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getQuiz(): ?Quiz
    {
        return $this->quiz;
    }

    public function setQuiz(?Quiz $quiz): self
    {
        $this->quiz = $quiz;

        return $this;
    }

    public function getNiveau(): ?Niveau
    {
        return $this->niveau;
    }

    public function setNiveau(?Niveau $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getTypePoste(): ?TypePoste
    {
        return $this->typePoste;
    }

    public function setTypePoste(?TypePoste $typePoste): self
    {
        $this->typePoste = $typePoste;

        return $this;
    }

    public function getTempsTotal(): ?int
    {
        return $this->tempsTotal;
    }

    public function setTempsTotal(?int $tempsTotal): self
    {
        $this->tempsTotal = $tempsTotal;

        return $this;
    }

    public function getDatePassage(): ?\DateTime
    {
        return $this->datePassage;
    }

    public function setDatePassage(?\DateTime $datePassage): self
    {
        $this->datePassage = $datePassage;

        return $this;
    }
}