<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\QuizUser;
use App\Repository\QuizRepository;
use App\Repository\QuizUserRepository;
use App\Repository\UserPositionRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlayQuizController extends AbstractController
{
    /**
     * @Route("/play/quiz/{id}", name="play_quiz")
     * @param $id
     */
    public function index(int $id, QuizRepository $quizRepository,QuizUserRepository $quizUserRepository,UserRepository $userRepository, UserPositionRepository $userPositionRepository): Response
    {
        if($quizRepository->find($id)->getStatus()) {
            $user = $userRepository->findByUsername($this->getUser()->getUsername());
            $playingUser = $quizUserRepository->findByUser($user);
            if ($userPositionRepository->findByUser($user,$id)==null) {
                if ($playingUser == null) {

                    $user->setStatus(true);

                    $currentTime = new \DateTime();
                    $quiz = $quizRepository->find($id);
                    $firstQuestion = $quiz->getQuizQuestions()[0];
                    $quizUser = new QuizUser();
                    $quizUser->setUser($user);
                    $quizUser->setQuiz($quiz);
                    $quizUser->setResult(0);
                    $quizUser->setCurrentQuestion(0);
                    $quizUser->setStartDate($currentTime);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($quizUser);
                    $em->flush();
                    $response = $this->forward('App\Controller\QuizPlayerController::index', [
                        'id' => $firstQuestion->getId(),
                        'quizId' => $id,
                        'firstId' => $firstQuestion->getId(),

                    ]);
                    return $response;
                } else {
                    return $this->redirectToRoute('quiz_player', [
                        'id' => $playingUser->getCurrentQuestion(),
                        'quizId' => $playingUser->getQuiz()->getId(),
                        'user'=> $user,
                    ]);
                }
            } else {
                $user->setStatus(false);
                return $this->redirectToRoute('user_rating',[
                    'id'=>$id,
                    'userId'=>$user->getId(),
                ]);
            }
        }
        else{
            return $this->redirectToRoute('quizzes');
        }
    }
}