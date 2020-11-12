<?php

namespace App\Controller;

use App\Entity\Quiz;
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
    public function index(QuestionRepository $questionRepository,Request $request): Response
    {
        $quiz=new Quiz();
        $form = $this->createForm(CreateQuizFormType::class, $quiz);
        $form->handleRequest($request);
        return $this->render('create_quiz/index.html.twig', [
            'controller_name' => 'CreateQuizController',
            'CreateQuizForm' => $form->createView(),
        ]);
    }
}
