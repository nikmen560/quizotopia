<?php

namespace App\Controller;

use App\Repository\QuizRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlayQuizController extends AbstractController
{
    /**
     * @Route("/play/quiz/{id}", name="play_quiz")
     * @param $id
     */
    public function index($id, QuizRepository $quizRepository): Response
    {
        $quiz=$quizRepository->find($id);
        $firstQuestion=$quiz->getQuizQuestions()[0];
        $response=$this->forward('App\Controller\QuizPlayerController::index',[
            'id' =>$firstQuestion->getId(),
            'quizid'=>$id,
            'firstId'=>$firstQuestion->getId(),
        ]);
        return $response;
    }
}