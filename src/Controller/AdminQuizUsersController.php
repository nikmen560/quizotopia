<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\QuizUserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class AdminQuizUsersController extends AbstractController
{
    /**
     * @Route("/admin/users/quiz", name="admin_quiz_users")
     */
    public function index(QuizUserRepository $quizUserRepository, Request $request): Response
    {
        $users = $quizUserRepository->findAll();
        return $this->render('admin_quiz_users/index.html.twig', [
            'users' => $users,
        ]);
    }
}
