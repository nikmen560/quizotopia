<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\UserPosition;
use App\Repository\QuizQuestionRepository;
use App\Repository\QuizRepository;
use App\Repository\QuizUserRepository;
use App\Repository\UserPositionRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserRatingController extends AbstractController
{
    /**
     * @Route("quiz/{id}/user/rating/{userId}", name="user_rating")
     * @param $userId
     * @param $id
     */
    public function index(int $id,int $userId,QuizUserRepository $quizUserRepository,UserRepository $userRepository,UserPositionRepository $userPositionRepository,QuizRepository $quizRepository, QuizQuestionRepository $quizQuestionRepository): Response
    {
        $user=$userRepository->find($userId);
        $playedUser=$quizUserRepository->findByUser($user);
        $currentUser=$userRepository->findByUsername($this->getUser()->getUsername());
        if($currentUser->getId()==$userId) {
            if ($playedUser != null) {
                if ($playedUser->getCurrentQuestion() == -1 && $playedUser->getQuiz()->getId()==$id) {
                    $userInRating = new UserPosition();
                    $userInRating->setUser($user);
                    $userInRating->setQuiz($quizRepository->find($id));
                    $userInRating->setResult($playedUser->getResult());
                    $spendedTime = new \DateTime();
                    $spendedTime =$spendedTime->diff($playedUser->getStartDate());
                    $userInRating->setSpendedTime($spendedTime);
                    $em = $this->getDoctrine()->getManager();
                    $em->remove($playedUser);
                    $em->persist($userInRating);
                    $em->flush();
                    return $this->redirectToRoute('user_rating',[
                        'userId'=>$userId,
                        'id' =>$id
                    ]);
                }
                else{
                    return $this->redirectToRoute('quiz_player', [
                        'id' => $playedUser->getCurrentQuestion(),
                        'quizId' => $playedUser->getQuiz()->getId(),
                    ]);
                }

            } else {
                $userInRating=$userPositionRepository->findByUser($user,$id);
                if($userInRating!=null){
                    $fullUserRating=$userPositionRepository->findRating($id);
                    $userRating=[];
                    $userPlace=0;
                    for($i=0;$i<count($fullUserRating);$i++){
                        if($i==3){
                            break;
                        }
                        $userRating[]=$fullUserRating[$i];
                    }
                    foreach($fullUserRating as $user){
                        $userPlace++;
                        if($user->getId()==$userInRating->getId()){
                            break;
                        }
                    }
                    $count=0;
                    return $this->render('user_rating/index.html.twig',
                    [
                        'userInRating'=> $userInRating,
                        'rating'=> $userRating,
                        'count'=> $count,
                        'place'=> $userPlace,
                    ]);
                }
                else{
                    return $this->redirectToRoute('quizzes');
                }
            }
        }
        else{
            return $this->redirectToRoute('quizzes');
        }
    }
}
