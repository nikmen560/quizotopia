<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\QuizQuestion;
use App\Repository\AnswerRepository;
use App\Repository\QuizQuestionRepository;
use App\Repository\QuizUserRepository;
use App\Repository\UserRepository;
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

    public function index(int $id, int $quizId,QuizQuestionRepository $quizQuestionRepository, UserRepository $userRepository, QuizUserRepository $quizUserRepository,$firstId=null): Response
    {
        $user=$userRepository->findByUsername($this->getUser()->getUsername());
        $playingUser=$quizUserRepository->findByUser($user);
        if($playingUser!=null) {
            if ($playingUser->getCurrentQuestion() == $id && $playingUser->getQuiz()->getId() == $quizId) {
                $nextQuestion = $quizQuestionRepository->findNextQuestion($id, $quizId);
            }
            elseif($playingUser->getCurrentQuestion()==0){
                $nextQuestion=$quizQuestionRepository->find($id);
            }
            else {
                return $this->redirectToRoute('quiz_player', [
                    'id' => $playingUser->getCurrentQuestion(),
                    'quizId' => $playingUser->getQuiz()->getId()
                ]);
            }
            $answers = $nextQuestion->getQuestion()->getAnswers();
            $playingUser->setCurrentQuestion($nextQuestion->getId());
            $em=$this->getDoctrine()->getManager();
            $em->persist($playingUser);
            $em->flush();
            return $this->render('quiz_player/index.html.twig', [
                'controller_name' => 'QuizPlayerController',
                'qq' => $nextQuestion,
                'quizId' => $quizId,
                'answers' => $answers,
            ]);
        }
        else{
            return $this->redirectToRoute('quizzes');
        }
    }

    /**
     * @Route ("quiz/player/check/{quizId}/{id}/{answerId}", name="quiz_check")
     * @param $id
     * @param $quizId
     * @param $answerId
     */
    public function check(int $id, int $quizId, int $answerId, AnswerRepository $answerRepository,QuizUserRepository $quizUserRepository,UserRepository $userRepository, QuizQuestionRepository $quizQuestionRepository):Response
    {
        $user=$userRepository->findByUsername($this->getUser()->getUsername());
        $playingUser=$quizUserRepository->findByUser($user);
        if($playingUser!=null){
            if ($playingUser->getCurrentQuestion() == $id && $playingUser->getQuiz()->getId() == $quizId) {
                $status=false;
                if($quizQuestionRepository->findMaxId($quizId)->getId()==$id){
                    $status=true;
                    $playingUser->setCurrentQuestion(-1);
                }
                $result=$playingUser->getResult();
                $isTrue = $answerRepository->find($answerId)->getIstrue();
                if($isTrue) {
                    $result++;
                }
                $playingUser->setResult($result);
                $em=$this->getDoctrine()->getManager();
                $em->persist($playingUser);
                $em->flush();
                return $this->render('quiz_player/check.html.twig', [
                    'quizId' => $quizId,
                    'isTrue' => $isTrue,
                    'qq' => $id,
                    'status'=>$status,
                    'user'=>$user,
                ]);
            }
            else {
                return $this->redirectToRoute('quiz_player', [
                    'id' => $playingUser->getCurrentQuestion(),
                    'quizId' => $playingUser->getQuiz()->getId(),
                ]);
            }
        }
        else {
            return $this->redirectToRoute('quizzes');
        }
    }
}
