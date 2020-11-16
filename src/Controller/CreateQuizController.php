<?php

namespace App\Controller;

use App\Entity\Quiz;
use App\Entity\QuizQuestion;
use App\Form\CreateQuizFormType;
use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateQuizController extends AbstractController
{
    /**
     * @Route("/create/quiz", name="create_quiz")
     */
    public function index(Request $request): Response
    {
        $quiz=new Quiz();
        $em=$this->getDoctrine()->getManager();
        $form = $this->createForm(CreateQuizFormType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $quiz->setName($form->get('quizName')->getData());
            $questions=$form->get('quizQuestions')->getData();
            $quiz->setStatus(true);
            $currentTime=new \DateTime();
            $quiz->setCreatedAt($currentTime);
            foreach ($questions as $question){
                $quizQuestion=new QuizQuestion();
                $quizQuestion->setQuestion($question);
                $quiz->addQuizQuestion($quizQuestion);
                $em->persist($quizQuestion);
            }
            $em->persist($quiz);
            $em->flush();
            return $this->redirectToRoute('admin');
        }
        return $this->render('create_quiz/index.html.twig', [
            'controller_name' => 'CreateQuizController',
            'CreateQuizForm' => $form->createView(),
        ]);
    }
}
