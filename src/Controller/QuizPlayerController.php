<?php

namespace App\Controller;

use App\Entity\QuizQuestion;
use App\Repository\QuizQuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuizPlayerController extends AbstractController
{
    /**
     * @Route("яquiz/player/{quizid}/{id}",name="quiz_player")
     * @param $id
     * @param $quizid
     */

    public function index($id, $quizid,QuizQuestionRepository $quizQuestionRepository): Response
    {
        $nextQuestion=$quizQuestionRepository->findNextQuestion($id,$quizid);
        return $this->render('quiz_player/index.html.twig', [
            'controller_name' => 'QuizPlayerController',
            'qq'=> $nextQuestion,
            'quizid'=>$quizid
        ]);
    }
}
