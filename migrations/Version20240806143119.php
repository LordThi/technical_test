<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240806143119 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Insert initial data into tables for Difficulte, Niveau, TypePoste, ThemeQuestion, TypeQuestion, Quiz, Question, Reponse, Candidat, and CandidatReponse';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO Difficulte (titre) VALUES ('Facile')");
        $this->addSql("INSERT INTO Difficulte (titre) VALUES ('Moyen')");
        $this->addSql("INSERT INTO Difficulte (titre) VALUES ('Difficile')");

        $this->addSql("INSERT INTO Niveau (titre) VALUES ('Junior')");
        $this->addSql("INSERT INTO Niveau (titre) VALUES ('Medium')");
        $this->addSql("INSERT INTO Niveau (titre) VALUES ('Lead')");
        $this->addSql("INSERT INTO Niveau (titre) VALUES ('Senior')");

        $this->addSql("INSERT INTO TypePoste (titre) VALUES ('Développeur Front')");
        $this->addSql("INSERT INTO TypePoste (titre) VALUES ('Développeur Back')");
        $this->addSql("INSERT INTO TypePoste (titre) VALUES ('Développeur FullStack')");
        $this->addSql("INSERT INTO TypePoste (titre) VALUES ('Admin Sys')");

        $this->addSql("INSERT INTO ThemeQuestion (titre) VALUES ('JS')");
        $this->addSql("INSERT INTO ThemeQuestion (titre) VALUES ('PHP')");
        $this->addSql("INSERT INTO ThemeQuestion (titre) VALUES ('React')");
        $this->addSql("INSERT INTO ThemeQuestion (titre) VALUES ('Symfony')");
        $this->addSql("INSERT INTO ThemeQuestion (titre) VALUES ('Design')");

        $this->addSql("INSERT INTO TypeQuestion (titre) VALUES ('QCM')");
        $this->addSql("INSERT INTO TypeQuestion (titre) VALUES ('Libre')");

    }

    public function down(Schema $schema): void
    {
        // Suppression des données insérées, pour éviter les conflits lors de la ré-exécution de la migration
        $this->addSql("DELETE FROM CandidatReponse");
        $this->addSql("DELETE FROM Candidat");
        $this->addSql("DELETE FROM Reponse");
        $this->addSql("DELETE FROM Question");
        $this->addSql("DELETE FROM Quiz");
        $this->addSql("DELETE FROM TypeQuestion");
        $this->addSql("DELETE FROM ThemeQuestion");
        $this->addSql("DELETE FROM TypePoste");
        $this->addSql("DELETE FROM Niveau");
        $this->addSql("DELETE FROM Difficulte");
    }
}
