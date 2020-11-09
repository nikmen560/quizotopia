<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminQuestionsController extends AbstractController
{
    /**
     * @Route("/admin/questions", name="admin_questions")
     */
    public function index(): Response
    {

        return $this->render('admin_questions/index.html.twig', [
            'controller_name' => 'AdminQuestionsController',
        ]);
    }
}
