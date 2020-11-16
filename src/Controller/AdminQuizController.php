<?php

namespace App\Controller;

use App\Entity\Quiz;
use App\Repository\QuizRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminQuizController extends AbstractController
{
    /**
     * @Route("/admin/quizes", name="admin_quizes")
     */
    public function index(QuizRepository $quizRepository, Request $request): Response
    {
        $quizzes = $quizRepository->findAll();
        return $this->render('admin_quiz/index.html.twig', [
            'quizzes' => $quizzes,
        ]);
    }
    /**
     * @Route("/admin/quizes/delete_quiz/{id}", name="delete_quiz")
     * @param $id
     */

    public function deleteQuiz($id)
    {
        $em = $this->getDoctrine()->getManager();
        $usr= $em->getRepository(Quiz::class)->find($id);
        $em->remove($usr);
        $em->flush();


        return $this->redirectToRoute('admin_quizes');
    }
    /**
     * @Route("/admin/quizes/block/{id}", name="block_quiz")
     * @param $id
     */

    public function blockQuiz($id)
    {
        $em = $this->getDoctrine()->getManager();
        $quiz= $em->getRepository(Quiz::class)->find($id);
        $quiz->setStatus(false);
        $em->persist($quiz);
        $em->flush();

        return $this->redirectToRoute('admin_quizes');
    }
    /**
     * @Route("/admin/quizes/unblock/{id}", name="unblock_quiz")
     * @param $id
     */
    public function unblockQuiz($id)
    {
        $em = $this->getDoctrine()->getManager();
        $quiz= $em->getRepository(Quiz::class)->find($id);
        $quiz->setStatus(true);
        $em->persist($quiz);
        $em->flush();

        return $this->redirectToRoute('admin_quizes');
    }
}
