<?php


namespace App\Form;

use App\Entity\Question;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CreateQuestionFormType extends \Symfony\Component\Form\AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextareaType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Enter a question',
                    ]),
                    new Length([
                       'max' => 500,
                    ])
                ]
            ])
            ->add('correct_answer',null,[
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter an answer',
                    ]),
                    new Length([
                        'max' => 100,
                    ])
                ],
            ])
            ->add('answer_1',null,[
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter an answer',
                    ]),
                    new Length([
                        'max' => 100,
                    ])
                ],
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }

}