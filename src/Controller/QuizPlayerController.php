<?php

namespace App\Controller;

use App\Entity\QuizQuestion;
use App\Repository\AnswerRepository;
use App\Repository\QuizQuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuizPlayerController extends AbstractController
{
    /**
     * @Route("quiz/player/{quizId}/{id}",name="quiz_player")
     * @param $id
     * @param $quizId
     */

    public function index($id, $quizId,QuizQuestionRepository $quizQuestionRepository,$firstId=null): Response
    {
        if($firstId==null) {
            $nextQuestion = $quizQuestionRepository->findNextQuestion($id, $quizId);
        }
        else{
            $nextQuestion=$quizQuestionRepository->find($id);
        }
        $answers=$nextQuestion->getQuestion()->getAnswers();
        return $this->render('quiz_player/index.html.twig', [
            'controller_name' => 'QuizPlayerController',
            'qq' => $nextQuestion,
            'quizId' => $quizId,
            'answers'=> $answers,
        ]);
    }

    /**
     * @Route ("quiz/player/check/{quizId}/{id}/{answerId}", name="quiz_check")
     * @param $id
     * @param $quizId
     * @param $answerId
     */
    public function check($id, $quizId, $answerId, AnswerRepository $answerRepository):Response
    {
        $isTrue=$answerRepository->find($answerId)->getIstrue();

        return $this->render('quiz_player/check.html.twig',[
            'quizId'=>$quizId,
            'isTrue'=>$isTrue,
            'qq'=>$id,
        ]);
    }
}
