<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240806132623 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Modification des tables existantes et ajout de nouvelles tables : ThemeQuestion et TypeQuestion. Mise à jour de la table Questions et Quiz, ajout de la colonne sortie_ecran à CandidatReponse.';
    }

    public function up(Schema $schema): void
    {
        // Supprimer les clés étrangères existantes sur Questions (utiliser les noms corrects)
        $this->addSql('ALTER TABLE Question DROP FOREIGN KEY Question_ibfk_1');
        $this->addSql('ALTER TABLE Question DROP FOREIGN KEY Question_ibfk_2');
        $this->addSql('ALTER TABLE Question DROP FOREIGN KEY Question_ibfk_3');

        // Supprimer les colonnes obsolètes de Questions
        $this->addSql('ALTER TABLE Question DROP COLUMN niveau_id');
        $this->addSql('ALTER TABLE Question DROP COLUMN type_poste_id');

        // Créer la table ThemeQuestion
        $this->addSql('CREATE TABLE ThemeQuestion (
            id INT AUTO_INCREMENT NOT NULL, 
            titre VARCHAR(255) NOT NULL, 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Créer la table TypeQuestion
        $this->addSql('CREATE TABLE TypeQuestion (
            id INT AUTO_INCREMENT NOT NULL, 
            titre VARCHAR(255) NOT NULL, 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Ajouter les nouvelles colonnes dans Questions
        $this->addSql('ALTER TABLE Question ADD difficulte_id INT NOT NULL');
        $this->addSql('ALTER TABLE Question ADD type_id INT NOT NULL');
        $this->addSql('ALTER TABLE Question ADD theme_id INT NOT NULL');

        // Ajouter les clés étrangères pour les nouvelles colonnes
        $this->addSql('ALTER TABLE Question ADD CONSTRAINT FK_QUESTION_DIFFICULTE FOREIGN KEY (difficulte_id) REFERENCES Difficulte (id)');
        $this->addSql('ALTER TABLE Question ADD CONSTRAINT FK_QUESTION_TYPE FOREIGN KEY (type_id) REFERENCES TypeQuestion (id)');
        $this->addSql('ALTER TABLE Question ADD CONSTRAINT FK_QUESTION_THEME FOREIGN KEY (theme_id) REFERENCES ThemeQuestion (id)');

        // Ajouter des index pour les nouvelles clés étrangères dans Questions
        $this->addSql('CREATE INDEX IDX_QUESTION_DIFFICULTE ON Question (difficulte_id)');
        $this->addSql('CREATE INDEX IDX_QUESTION_TYPE ON Question (type_id)');
        $this->addSql('CREATE INDEX IDX_QUESTION_THEME ON Question (theme_id)');

        // Supprimer la clé étrangère et la colonne obsolètes dans Quiz
        $this->addSql('ALTER TABLE Quiz DROP FOREIGN KEY Quiz_ibfk_1');
        $this->addSql('ALTER TABLE Quiz DROP COLUMN difficulte_id');

        // Ajouter les nouvelles colonnes dans Quiz
        $this->addSql('ALTER TABLE Quiz ADD nombre_questions INT NOT NULL');

        // Ajouter un index pour les nouvelles colonnes dans Quiz
        $this->addSql('CREATE INDEX IDX_QUIZ_NOMBRE_QUESTIONS ON Quiz (nombre_questions)');

        // Ajouter la nouvelle colonne dans CandidatReponse
        $this->addSql('ALTER TABLE CandidatReponse ADD sortie_ecran TINYINT(1) DEFAULT 0 NOT NULL');
        
    }

    public function down(Schema $schema): void
    {
        // Revert `Questions` table
        $this->addSql('ALTER TABLE Question DROP FOREIGN KEY FK_QUESTION_DIFFICULTE');
        $this->addSql('ALTER TABLE Question DROP FOREIGN KEY FK_QUESTION_TYPE');
        $this->addSql('ALTER TABLE Question DROP FOREIGN KEY FK_QUESTION_THEME');
        $this->addSql('ALTER TABLE Question DROP COLUMN difficulte_id');
        $this->addSql('ALTER TABLE Question DROP COLUMN type_id');
        $this->addSql('ALTER TABLE Question DROP COLUMN theme_id');
        $this->addSql('ALTER TABLE Question ADD niveau_id INT NOT NULL');
        $this->addSql('ALTER TABLE Question ADD type_poste_id INT NOT NULL');
        $this->addSql('ALTER TABLE Question ADD CONSTRAINT Question_ibfk_1 FOREIGN KEY (niveau_id) REFERENCES Niveau (id)');
        $this->addSql('ALTER TABLE Question ADD CONSTRAINT Question_ibfk_2 FOREIGN KEY (type_poste_id) REFERENCES TypePoste (id)');
        $this->addSql('ALTER TABLE Question ADD CONSTRAINT Question_ibfk_3 FOREIGN KEY (quiz_id) REFERENCES Quiz (id)');

        // Revert `Quiz` table
        $this->addSql('ALTER TABLE Quiz DROP COLUMN nombre_questions');
        $this->addSql('ALTER TABLE Quiz ADD difficulte_id INT NOT NULL');
        $this->addSql('ALTER TABLE Quiz ADD CONSTRAINT FK_QUIZ_DIFFICULTE FOREIGN KEY (difficulte_id) REFERENCES Difficulte (id)');

        // Revert `CandidatReponse` table
        $this->addSql('ALTER TABLE CandidatReponse DROP COLUMN sortie_ecran');

        // Drop new tables
        $this->addSql('DROP TABLE ThemeQuestion');
        $this->addSql('DROP TABLE TypeQuestion');
    }
}
