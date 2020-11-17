<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\QuizRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuizesListController extends AbstractController
{
    /**
     * @Route("/quizzes", name="quizzes")
     */
    public function index(QuizRepository $quizRepository): Response
    {
        $quizzes=$quizRepository->findAll();
        return $this->render('quizes_list/index.html.twig',[
            'quizzes'=>$quizzes,
        ]);
    }
}
