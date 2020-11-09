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
        $questions = $questionRepository->findAllQuestions();
        $answers = $answerRepository->findAllAnswers();
        $result = $paginator->paginate(
            $questions,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)
        );
        return $this->render('admin_questions/index.html.twig', [
            'questions' => $result,
        ]);
    }
}
