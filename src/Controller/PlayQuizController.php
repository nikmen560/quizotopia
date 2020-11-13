<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlayQuizController extends AbstractController
{
    /**
     * @Route("/play/quiz/{id}", name="play_quiz")
     * @param $id
     */
    public function index($id): Response
    {
        return $this->render('play_quiz/index.html.twig', [
            'controller_name' => 'PlayQuizController',
        ]);
    }
}
