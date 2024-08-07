<?php

// src/Form/QuestionType.php
namespace App\Form;

use App\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('texteQuestion', TextType::class, [
                'label' => 'Intitulé',
            ])
            ->add('difficulte', ChoiceType::class, [
                'choices' => $options['difficulte_choices'],
                'choice_label' => function ($difficulte) {
                    return $difficulte->getTitre();
                },
                'label' => 'Difficulté',
            ])
            ->add('themeQuestion', ChoiceType::class, [
                'choices' => $options['theme_choices'],
                'choice_label' => function ($themeQuestion) {
                    return $themeQuestion->getTitre();
                },
                'label' => 'Thème',
            ])
            ->add('typeQuestion', ChoiceType::class, [
                'choices' => $options['type_choices'],
                'choice_label' => function ($type) {
                    return $type->getTitre();
                },
                'label' => 'Type de question',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
            'difficulte_choices' => [],
            'theme_choices' => [],
            'type_choices' => [],
        ]);
    }
}
