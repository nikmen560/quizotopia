<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\QuizRepository;
use App\Repository\UserPositionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuizesListController extends AbstractController
{
    /**
     * @Route("/quizzes", name="quizzes")
     */
    public function index(QuizRepository $quizRepository,UserPositionRepository $userPositionRepository): Response
    {
        if(in_array("ROLE_ADMIN",$this->getUser()->getRoles())){
            return $this->redirectToRoute('admin');
        }
        $users=$userPositionRepository->findLeaders();
        $quizzes=$quizRepository->findAll();
        $usersCount=$userPositionRepository->findUserCount();
        $status=true;
        $i=0;
        foreach ($quizzes as $quiz){
            foreach ($users as $user){
                if($user->getQuiz()->getId()==$quiz->getId()){
                    $quiz->leader=$user->getUser()->getUsername();
                    $quiz->count=-1;
                    $status=false;
                    break;
                }
                if($status){
                    $quiz->leader='No leaders yet';
                    $quiz->count=0;
                }
                $status=true;
            }
        }
        foreach ($quizzes as $quiz) {
            if($quiz->count!=0){
                $quiz->count=$usersCount[$i][1];
                $i++;
            }
        }
        return $this->render('quizes_list/index.html.twig',[
            'quizzes'=>$quizzes,
        ]);
    }
}
