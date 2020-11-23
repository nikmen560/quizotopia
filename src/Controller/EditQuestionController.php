<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\EditQuestionFormType;
use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditQuestionController extends AbstractController
{

    /**
     * @Route("/edit/question/{id}", name="edit_question")
     * @param $id
     *
     */
    public function index(Request $request, int $id,QuestionRepository $questionRepository): Response
    {
        $question=$questionRepository->find($id);
        $answers=$question->getAnswers();
        $answersContent=[];
        foreach ($answers as $answer){
            $answersContent[]=$answer->getContent();
        }
        $form=$this->createForm(EditQuestionFormType::class,$question,[
            'count'=>count($answers),
            'question'=>$question->getContent(),
            'answers'=>$answersContent,
        ]);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $entityManager=$this->getDoctrine()->getManager();
            $question->setContent($form->get('content')->getData());
            $answers[0]->setContent($form->get('correct_answer')->getData());
            for($i=1;$i<count($answers);$i++){
                $answers[$i]->setContent($form->get('answer_'.$i)->getData());
            }
            $entityManager->persist($question);
            $entityManager->flush();
            return $this->redirectToRoute('admin_questions');
        }
        return $this->render('edit_question/index.html.twig',[
           'form'=>$form->createView(),
            'count'=>count($answers)-1,
            'question'=>$question->getContent(),
            'answers'=>$answersContent
        ]);
    }
}