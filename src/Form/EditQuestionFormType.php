<?php


namespace App\Form;


use App\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class EditQuestionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextareaType::class, [
                'attr' =>[
                  'value'=>$options['question'],
                ],
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
                'attr'=>[
                    'value'=>$options['answers'][0],
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter an answer',
                    ]),
                    new Length([
                        'max' => 100,
                    ])
                ],
            ]);
        for($i=1;$i<$options['count'];$i++) {
            $builder->add('answer_'.$i, null, [
                'attr'=>[
                    'value'=>$options['answers'][$i],
                ],
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter an answer',
                    ]),
                    new Length([
                        'max' => 100,
                    ])
                ],
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
            'count' => null,
            'answers' => null,
            'question' => null,
        ]);
    }

}