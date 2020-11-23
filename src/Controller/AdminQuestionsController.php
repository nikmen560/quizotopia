<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Question;
use App\Repository\AnswerRepository;
use App\Repository\QuestionRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminQuestionsController extends AbstractController
{
    /**
     * @Route("/admin/questions", name="admin_questions")
     */
    public function index(QuestionRepository $questionRepository, AnswerRepository $answerRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $questions = $questionRepository->findAll();
        $answers=$answerRepository->findAll();
        return $this->render('admin_questions/index.html.twig', [
            'questions' => $questions,
            'answers'=> $answers,
        ]);
    }
    /**
     * @Route("/admin/questions/delete_question/{id}", name="delete_question")
     * @param $id
     */
    public function deleteUser(int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $usr= $em->getRepository(Question::class)->find($id);
        $em->remove($usr);
        $em->flush();


        return $this->redirectToRoute('admin_questions');
    }
}
