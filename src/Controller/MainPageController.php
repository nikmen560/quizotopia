<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainPageController extends AbstractController
{
    /**
     * @Route("/", name="mainpage")
     */
    public function index(UserRepository $userRepository): Response
    {
        if ($this->getUser()) {
            $user=$userRepository->findByUsername($this->getUser()->getUsername());
            if(in_array("ROLE_ADMIN",$user->getRoles()))
            {
                return $this->redirectToRoute('admin');
            }
            return $this->redirectToRoute('quizzes');
        }
        return $this->render('home/index.html.twig');
    }
}
