<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Question;
use App\Form\AnswerCountFormType;
use App\Form\CreateQuestionFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CreateQuestionController extends AbstractController
{
    /**
     * @Route("/create/question",name="initial_create_question")
     */
    public function create(Request $request):Response{
        $form=$this->createForm(AnswerCountFormType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            if($form->get('answerCount')->getData()>7||$form->get('answerCount')->getData()<=1){
                return $this->render('create_question/answer.html.twig', [
                    'form'=>$form->createView(),
                    'error'=>'Wrong answer range is 1 to 7',
                ]);
            }
            return $this->redirectToRoute('create_question',[
                'count'=>$form->get('answerCount')->getData(),
            ]);
        }
        return $this->render('create_question/answer.html.twig', [
            'form'=>$form->createView(),
            'error'=>null,
        ]);
    }
    /**
     * @Route("/create/question/{count}", name="create_question")
     * @param $count
     */
    public function index(Request $request, int $count): Response
    {
        $question=new Question();
        $form = $this->createForm(CreateQuestionFormType::class, $question,[
            'count'=>$count
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $answer=new Answer();
            $answer->setContent($form->get('correct_answer')->getData());
            $answer->setIstrue(true);
            $entityManager->persist($answer);
            $question->addAnswer($answer);
            for($i=0; $i<$count; $i++) {
                $answer = new Answer();
                $answer->setContent($form->get('answer_'.$i)->getData());
                $answer->setIstrue(false);
                $question->addAnswer($answer);
                $entityManager->persist($answer);
            }
            $entityManager->persist($question);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('admin');
        }
        return $this->render('create_question/index.html.twig', [
            'CreateQuestionForm' => $form->createView(),
            'count'=> $count,
        ]);
    }
}
