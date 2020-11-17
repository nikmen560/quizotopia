<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Form\AnswerCountFormType;
use App\Form\CreateQuestionFormType;
use App\Entity\Question;
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
    public function index(Request $request, $id): Response
    {
        $question = $this->getDoctrine()->getRepository(Question::class)->find($id);
        $answers = $question->getAnswers();
        $count = count($answers);
        $form = $this->createForm(CreateQuestionFormType::class, $question, [
            'count' => $count,
            'answers' => $answers
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

//            foreach ($answers as $answer) {

                $entityManager = $this->getDoctrine()->getManager();

//                $answer->setIstrue(true);
//                $question->addAnswer($answer);
//
//                for ($i = 1; $i < $count; $i++) {
//                    $answer = new Answer();
//                    $answer = $this->getDoctrine()->getRepository(Answer::class)->findBy(array('question_id' => $id)[$i]);
//                    $question->addAnswer($answer);
//                }
//            }
            $entityManager->flush();

            return $this->redirectToRoute('admin_questions');
        }
        return $this->render('edit_question/index.html.twig', [
            'CreateQuestionForm' => $form->createView(),
            'count' => $count,
            'answers' => $answers
        ]);
    }
}