<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240807094432 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'initial database creation';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE CandidatReponse (id INT AUTO_INCREMENT NOT NULL, candidat_id INT NOT NULL, question_id INT NOT NULL, reponse_id INT NOT NULL, date_reponse DATETIME NOT NULL, sortie_ecran TINYINT(1) NOT NULL, INDEX IDX_5F36C33A8D0EB82 (candidat_id), INDEX IDX_5F36C33A1E27F6BF (question_id), INDEX IDX_5F36C33ACF18BB82 (reponse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Candidats (id INT AUTO_INCREMENT NOT NULL, quiz_id INT DEFAULT NULL, niveau_id INT DEFAULT NULL, type_poste_id INT DEFAULT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, email VARCHAR(255) NOT NULL, temps_total INT DEFAULT NULL, date_passage DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_BE97B9B6E7927C74 (email), INDEX IDX_BE97B9B6853CD175 (quiz_id), INDEX IDX_BE97B9B6B3E9C81 (niveau_id), INDEX IDX_BE97B9B66D6F777A (type_poste_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Difficulte (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_E0373070FF7747B4 (titre), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Niveau (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Question (id INT AUTO_INCREMENT NOT NULL, difficulte_id INT NOT NULL, quiz_id INT NOT NULL, theme_id INT NOT NULL, type_id INT NOT NULL, texte_question VARCHAR(255) NOT NULL, INDEX IDX_4F812B18E6357589 (difficulte_id), INDEX IDX_4F812B18853CD175 (quiz_id), INDEX IDX_4F812B1859027487 (theme_id), INDEX IDX_4F812B18C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Quiz (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, temps_max INT NOT NULL, nombre_questions INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Reponse (id INT AUTO_INCREMENT NOT NULL, question_id INT NOT NULL, texte_reponse LONGTEXT NOT NULL, is_correct TINYINT(1) NOT NULL, INDEX IDX_900BE75B1E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ThemeQuestion (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE TypePoste (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE TypeQuestion (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE CandidatReponse ADD CONSTRAINT FK_5F36C33A8D0EB82 FOREIGN KEY (candidat_id) REFERENCES Candidats (id)');
        $this->addSql('ALTER TABLE CandidatReponse ADD CONSTRAINT FK_5F36C33A1E27F6BF FOREIGN KEY (question_id) REFERENCES Question (id)');
        $this->addSql('ALTER TABLE CandidatReponse ADD CONSTRAINT FK_5F36C33ACF18BB82 FOREIGN KEY (reponse_id) REFERENCES Reponse (id)');
        $this->addSql('ALTER TABLE Candidats ADD CONSTRAINT FK_BE97B9B6853CD175 FOREIGN KEY (quiz_id) REFERENCES Quiz (id)');
        $this->addSql('ALTER TABLE Candidats ADD CONSTRAINT FK_BE97B9B6B3E9C81 FOREIGN KEY (niveau_id) REFERENCES Niveau (id)');
        $this->addSql('ALTER TABLE Candidats ADD CONSTRAINT FK_BE97B9B66D6F777A FOREIGN KEY (type_poste_id) REFERENCES TypePoste (id)');
        $this->addSql('ALTER TABLE Question ADD CONSTRAINT FK_4F812B18E6357589 FOREIGN KEY (difficulte_id) REFERENCES Difficulte (id)');
        $this->addSql('ALTER TABLE Question ADD CONSTRAINT FK_4F812B18853CD175 FOREIGN KEY (quiz_id) REFERENCES Quiz (id)');
        $this->addSql('ALTER TABLE Question ADD CONSTRAINT FK_4F812B1859027487 FOREIGN KEY (theme_id) REFERENCES ThemeQuestion (id)');
        $this->addSql('ALTER TABLE Question ADD CONSTRAINT FK_4F812B18C54C8C93 FOREIGN KEY (type_id) REFERENCES TypeQuestion (id)');
        $this->addSql('ALTER TABLE Reponse ADD CONSTRAINT FK_900BE75B1E27F6BF FOREIGN KEY (question_id) REFERENCES Question (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE CandidatReponse DROP FOREIGN KEY FK_5F36C33A8D0EB82');
        $this->addSql('ALTER TABLE CandidatReponse DROP FOREIGN KEY FK_5F36C33A1E27F6BF');
        $this->addSql('ALTER TABLE CandidatReponse DROP FOREIGN KEY FK_5F36C33ACF18BB82');
        $this->addSql('ALTER TABLE Candidats DROP FOREIGN KEY FK_BE97B9B6853CD175');
        $this->addSql('ALTER TABLE Candidats DROP FOREIGN KEY FK_BE97B9B6B3E9C81');
        $this->addSql('ALTER TABLE Candidats DROP FOREIGN KEY FK_BE97B9B66D6F777A');
        $this->addSql('ALTER TABLE Question DROP FOREIGN KEY FK_4F812B18E6357589');
        $this->addSql('ALTER TABLE Question DROP FOREIGN KEY FK_4F812B18853CD175');
        $this->addSql('ALTER TABLE Question DROP FOREIGN KEY FK_4F812B1859027487');
        $this->addSql('ALTER TABLE Question DROP FOREIGN KEY FK_4F812B18C54C8C93');
        $this->addSql('ALTER TABLE Reponse DROP FOREIGN KEY FK_900BE75B1E27F6BF');
        $this->addSql('DROP TABLE CandidatReponse');
        $this->addSql('DROP TABLE Candidats');
        $this->addSql('DROP TABLE Difficulte');
        $this->addSql('DROP TABLE Niveau');
        $this->addSql('DROP TABLE Question');
        $this->addSql('DROP TABLE Quiz');
        $this->addSql('DROP TABLE Reponse');
        $this->addSql('DROP TABLE ThemeQuestion');
        $this->addSql('DROP TABLE TypePoste');
        $this->addSql('DROP TABLE TypeQuestion');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
