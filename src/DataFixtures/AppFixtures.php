<?php

namespace App\DataFixtures;

use App\Entity\CandidatReponse;
use App\Entity\Difficulte;
use App\Entity\Niveau;
use App\Entity\TypePoste;
use App\Entity\ThemeQuestion;
use App\Entity\TypeQuestion;
use App\Entity\Quiz;
use App\Entity\Question;
use App\Entity\Reponse;
use App\Entity\Candidat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // Create Difficulte
        $difficulte = new Difficulte();
        $difficulte->setTitre('Facile');
        $manager->persist($difficulte);

        $difficulte = new Difficulte();
        $difficulte->setTitre('Moyen');
        $manager->persist($difficulte);

        $difficulte = new Difficulte();
        $difficulte->setTitre('Difficile');
        $manager->persist($difficulte);

        // Create Niveau
        $niveau = new Niveau();
        $niveau->setTitre('Junior');
        $manager->persist($niveau);

        $niveau = new Niveau();
        $niveau->setTitre('Medium');
        $manager->persist($niveau);

        $niveau = new Niveau();
        $niveau->setTitre('Lead');
        $manager->persist($niveau);

        $niveau = new Niveau();
        $niveau->setTitre('Senior');
        $manager->persist($niveau);

        // Create TypePoste
        $typePoste = new TypePoste();
        $typePoste->setTitre('Développeur Front');
        $manager->persist($typePoste);

        $typePoste = new TypePoste();
        $typePoste->setTitre('Développeur Back');
        $manager->persist($typePoste);

        $typePoste = new TypePoste();
        $typePoste->setTitre('Développeur FullStack');
        $manager->persist($typePoste);

        $typePoste = new TypePoste();
        $typePoste->setTitre('Admin Sys');
        $manager->persist($typePoste);

        // Create ThemeQuestion
        $themeQuestion = new ThemeQuestion();
        $themeQuestion->setTitre('JS');
        $manager->persist($themeQuestion);

        $themeQuestion = new ThemeQuestion();
        $themeQuestion->setTitre('PHP');
        $manager->persist($themeQuestion);

        $themeQuestion = new ThemeQuestion();
        $themeQuestion->setTitre('React');
        $manager->persist($themeQuestion);

        $themeQuestion = new ThemeQuestion();
        $themeQuestion->setTitre('Symfony');
        $manager->persist($themeQuestion);

        $themeQuestion = new ThemeQuestion();
        $themeQuestion->setTitre('Design');
        $manager->persist($themeQuestion);

        // Create TypeQuestion
        $typeQuestion = new TypeQuestion();
        $typeQuestion->setTitre('QCM');
        $manager->persist($typeQuestion);

        $typeQuestion = new TypeQuestion();
        $typeQuestion->setTitre('Libre');
        $manager->persist($typeQuestion);

        // Create Quiz
        $quiz = new Quiz();
        $quiz->setTitre('Quiz Développeur');
        $quiz->setDifficulte($difficulte); // Assume difficulty level is 'Facile'
        $quiz->setTempsAlloue(30);
        $manager->persist($quiz);

        // Create Question
        $question = new Question();
        $question->setTexteQuestion('Quelle est la méthode pour créer un objet en PHP ?');
        $question->setDifficulte($difficulte);
        $question->setTypeQuestion($typeQuestion); // Assume type question is 'Choix Multiple'
        $question->setThemeQuestion($themeQuestion); // Assume theme question is 'Développement Web'
        $question->setQuiz($quiz);
        $manager->persist($question);

        // Create Reponse
        $reponse = new Reponse();
        $reponse->setQuestion($question);
        $reponse->setTexteReponse('new Object()');
        $reponse->setIsCorrect(true);
        $manager->persist($reponse);

        $reponse = new Reponse();
        $reponse->setQuestion($question);
        $reponse->setTexteReponse('create()');
        $reponse->setIsCorrect(false);
        $manager->persist($reponse);

        // Create Candidat
        $candidat = new Candidat();
        $candidat->setNom('Dupont');
        $candidat->setPrenom('Jean');
        $candidat->setEmail('jean.dupont@example.com');
        $candidat->setQuiz($quiz);
        $candidat->setNiveau($niveau); // Assume level is 'Débutant'
        $candidat->setTypePoste($typePoste); // Assume type poste is 'Développeur'
        $candidat->setTempsTotal(45);
        $candidat->setDatePassage(new \DateTime());
        $manager->persist($candidat);

        // Create CandidatReponse
        $candidatReponse = new CandidatReponse();
        $candidatReponse->setCandidat($candidat);
        $candidatReponse->setReponse($reponse);
        $candidatReponse->setQuestion($question);
        $candidatReponse->setTempsReponse(45);
        $candidatReponse->setSortieEcran(false);
        $manager->persist($candidatReponse);

        // Flush all changes
        $manager->flush();
    }
}
