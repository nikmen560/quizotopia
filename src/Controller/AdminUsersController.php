<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminUsersController extends AbstractController
{
    /**
     * @Route("/admin/users", name="admin_users")
     */
    public function index(UserRepository $userRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $users = $userRepository->findAll();

        return $this->render('admin_users/index.html.twig', [
            'users' => $users,
        ]);
    }
    /**
     * @Route("/admin/users/delete_user/{id}", name="delete_user")
     * @param $id
     */
    public function deleteUser($id)
    {
        $em = $this->getDoctrine()->getManager();
        $usr= $em->getRepository(User::class)->find($id);
        $em->remove($usr);
        $em->flush();


        return $this->redirectToRoute('admin_users');
    }
}
