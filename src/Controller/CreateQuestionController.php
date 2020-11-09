<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Question;
use App\Form\CreateQuestionFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CreateQuestionController extends AbstractController
{
    /**
     * @Route("/create/question", name="create_question")
     */
    public function index(Request $request): Response
    {
        $question=new Question();
        $form = $this->createForm(CreateQuestionFormType::class, $question);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $answer=new Answer();
            $answer->setContent($form->get('correct_answer')->getData());
            $answer->setIstrue(true);
            $entityManager->persist($answer);
            $question->addAnswer($answer);
            $answer=new Answer();
            $answer->setContent($form->get('answer_1')->getData());
            $answer->setIstrue(false);
            $question->addAnswer($answer);
            $entityManager->persist($answer);
            $entityManager->persist($question);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('admin');
        }
        return $this->render('create_question/index.html.twig', [
            'CreateQuestionForm' => $form->createView(),
        ]);
    }
}
