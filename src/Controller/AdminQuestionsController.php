<?php

namespace App\Controller;

use App\Repository\AnswerRepository;
use App\Repository\QuestionRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminQuestionsController extends AbstractController
{
    /**
     * @Route("/admin/questions", name="admin_questions")
     */
    public function index(QuestionRepository $questionRepository, AnswerRepository $answerRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $questions = $questionRepository->findAll();
        return $this->render('admin_questions/index.html.twig', [
            'questions' => $questions,
        ]);
    }
}
