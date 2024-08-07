<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240807094500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Populate database with example data and ensure foreign key constraints are respected';
    }

    public function up(Schema $schema): void
    {
        // Insertion de données dans la table Difficulte
        $this->addSql("INSERT INTO Difficulte (titre) VALUES ('Facile')");
        $this->addSql("INSERT INTO Difficulte (titre) VALUES ('Moyen')");
        $this->addSql("INSERT INTO Difficulte (titre) VALUES ('Difficile')");

        // Insertion de données dans la table Niveau
        $this->addSql("INSERT INTO Niveau (titre) VALUES ('Stagiaire')");
        $this->addSql("INSERT INTO Niveau (titre) VALUES ('Alternant')");
        $this->addSql("INSERT INTO Niveau (titre) VALUES ('Junior')");
        $this->addSql("INSERT INTO Niveau (titre) VALUES ('Intermédiaire')");
        $this->addSql("INSERT INTO Niveau (titre) VALUES ('Senior')");
        $this->addSql("INSERT INTO Niveau (titre) VALUES ('Lead')");

        // Insertion de données dans la table TypePoste
        $this->addSql("INSERT INTO TypePoste (titre) VALUES ('Développeur Front')");
        $this->addSql("INSERT INTO TypePoste (titre) VALUES ('Développeur Back')");
        $this->addSql("INSERT INTO TypePoste (titre) VALUES ('Développeur FullStack')");
        $this->addSql("INSERT INTO TypePoste (titre) VALUES ('Admin Sys')");
        $this->addSql("INSERT INTO TypePoste (titre) VALUES ('Designer UX')");

        // Insertion de données dans la table ThemeQuestion
        $this->addSql("INSERT INTO ThemeQuestion (titre) VALUES ('PHP')");
        $this->addSql("INSERT INTO ThemeQuestion (titre) VALUES ('JS')");
        $this->addSql("INSERT INTO ThemeQuestion (titre) VALUES ('React')");
        $this->addSql("INSERT INTO ThemeQuestion (titre) VALUES ('Symfony')");
        $this->addSql("INSERT INTO ThemeQuestion (titre) VALUES ('Bash')");
        $this->addSql("INSERT INTO ThemeQuestion (titre) VALUES ('HTML')");
        $this->addSql("INSERT INTO ThemeQuestion (titre) VALUES ('Bootstrap')");
        $this->addSql("INSERT INTO ThemeQuestion (titre) VALUES ('CSS')");
        $this->addSql("INSERT INTO ThemeQuestion (titre) VALUES ('UX/UI')");
        $this->addSql("INSERT INTO ThemeQuestion (titre) VALUES ('Culture Dev')");

        // Insertion de données dans la table TypeQuestion
        $this->addSql("INSERT INTO TypeQuestion (titre) VALUES ('Choix multiple')");
        $this->addSql("INSERT INTO TypeQuestion (titre) VALUES ('Vrai/Faux')");
        $this->addSql("INSERT INTO TypeQuestion (titre) VALUES ('Réponse courte')");


    }

    public function down(Schema $schema): void
    {
        // Suppression des données insérées pour rollback
        $this->addSql("DELETE FROM CandidatReponse");
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
