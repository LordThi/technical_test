<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240802151357 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create tables for Candidats, Quiz, Niveau, TypePoste, Question, Reponse, CandidatReponse, and Difficulte with indexes.';
    }

    public function up(Schema $schema): void
    {
        // Create table Difficulte first (because it is referenced by Quiz)
        $this->addSql('CREATE TABLE Difficulte (
            id INT AUTO_INCREMENT NOT NULL, 
            titre VARCHAR(100) NOT NULL, 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Create table Niveau
        $this->addSql('CREATE TABLE Niveau (
            id INT AUTO_INCREMENT NOT NULL, 
            titre VARCHAR(100) NOT NULL, 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Create table TypePoste
        $this->addSql('CREATE TABLE TypePoste (
            id INT AUTO_INCREMENT NOT NULL, 
            titre VARCHAR(100) NOT NULL, 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Create table Quiz
        $this->addSql('CREATE TABLE Quiz (
            id INT AUTO_INCREMENT NOT NULL, 
            titre VARCHAR(255) NOT NULL, 
            difficulte_id INT NOT NULL, 
            temps_max INT NOT NULL, 
            PRIMARY KEY(id), 
            INDEX IDX_QUIZ_DIFFICULTE (difficulte_id),
            FOREIGN KEY (difficulte_id) REFERENCES Difficulte(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Create table Question
        $this->addSql('CREATE TABLE Question (
            id INT AUTO_INCREMENT NOT NULL, 
            texte_question TEXT NOT NULL, 
            niveau_id INT NOT NULL, 
            type_poste_id INT NOT NULL, 
            quiz_id INT NOT NULL, 
            PRIMARY KEY(id), 
            INDEX IDX_QUESTION_NIVEAU (niveau_id),
            INDEX IDX_QUESTION_TYPE_POSTE (type_poste_id),
            INDEX IDX_QUESTION_QUIZ (quiz_id),
            FOREIGN KEY (niveau_id) REFERENCES Niveau(id), 
            FOREIGN KEY (type_poste_id) REFERENCES TypePoste(id), 
            FOREIGN KEY (quiz_id) REFERENCES Quiz(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Create table Reponse
        $this->addSql('CREATE TABLE Reponse (
            id INT AUTO_INCREMENT NOT NULL, 
            question_id INT NOT NULL, 
            texte_reponse TEXT NOT NULL, 
            is_correct TINYINT(1) NOT NULL, 
            PRIMARY KEY(id), 
            INDEX IDX_REPONSE_QUESTION (question_id),
            FOREIGN KEY (question_id) REFERENCES Question(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Create table Candidats
        $this->addSql('CREATE TABLE Candidats (
            id INT AUTO_INCREMENT NOT NULL, 
            nom VARCHAR(100) NOT NULL, 
            prenom VARCHAR(100) NOT NULL, 
            email VARCHAR(255) NOT NULL UNIQUE, 
            quiz_id INT NOT NULL, 
            niveau_id INT NOT NULL, 
            type_poste_id INT NOT NULL, 
            temps_total INT DEFAULT NULL, 
            date_passage DATETIME DEFAULT NULL, 
            PRIMARY KEY(id), 
            INDEX IDX_CANDIDATS_QUIZ (quiz_id),
            INDEX IDX_CANDIDATS_NIVEAU (niveau_id),
            INDEX IDX_CANDIDATS_TYPE_POSTE (type_poste_id),
            FOREIGN KEY (quiz_id) REFERENCES Quiz(id), 
            FOREIGN KEY (niveau_id) REFERENCES Niveau(id), 
            FOREIGN KEY (type_poste_id) REFERENCES TypePoste(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Create table CandidatReponse
        $this->addSql('CREATE TABLE CandidatReponse (
            id INT AUTO_INCREMENT NOT NULL, 
            candidat_id INT NOT NULL, 
            reponse_id INT NOT NULL, 
            question_id INT NOT NULL, 
            date_reponse DATETIME DEFAULT NULL, 
            PRIMARY KEY(id), 
            INDEX IDX_CANDIDAT_REPONSE_CANDIDAT (candidat_id),
            INDEX IDX_CANDIDAT_REPONSE_REPONSE (reponse_id),
            INDEX IDX_CANDIDAT_REPONSE_QUESTION (question_id),
            FOREIGN KEY (candidat_id) REFERENCES Candidats(id), 
            FOREIGN KEY (reponse_id) REFERENCES Reponse(id),
            FOREIGN KEY (question_id) REFERENCES Question(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE CandidatReponse');
        $this->addSql('DROP TABLE Candidats');
        $this->addSql('DROP TABLE Reponse');
        $this->addSql('DROP TABLE Question');
        $this->addSql('DROP TABLE Quiz');
        $this->addSql('DROP TABLE TypePoste');
        $this->addSql('DROP TABLE Niveau');
        $this->addSql('DROP TABLE Difficulte');
    }
}
