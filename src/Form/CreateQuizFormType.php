<?php

declare(strict_types=1);

namespace App\Form;


use App\Entity\Question;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateQuizFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('quizQuestions',EntityType::class,[
            'class'=>Question::class,
            'choice_label' => 'content',
            'multiple' => true,
            'expanded' =>true,
            'choice_value' => function (Question $question) {
                return $question ? $question->getId() : '';
            },
        ])
            ->add('quizName');

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}