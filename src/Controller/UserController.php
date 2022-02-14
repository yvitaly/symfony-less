<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */

public function index(Request $request): Response
    {
        $user = new User();
        $searchfor = $request->query->get('searchfor');
        if ($searchfor){
            $users = $this->getDoctrine()->getRepository(User::class)->findBy(['email'=>$searchfor]);
        }
        else {
            $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        }
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user');

        }

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'form' => $form->createView(),
            'users'=>$users,
            'searchfor'=>$searchfor
        ]);


        /*$user = new User();
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findBy([], [$orderBy => $order], $limit)

        ;

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'users'=>$users
        ]);  */
    }

    /**
     * @Route("/user/edit/{email}", name="edit-user")
     */

    public function edit(User $user, Request $request, EntityManagerInterface $em): Response
    {


        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'User edited');
            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('user');
        }
        return $this->render('user/edit.html.twig', [
            'controller_name' => 'UserController',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/user/add", name="add-user")
     */
    public function add(Request $request): Response
    {
        $user = new User();
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user');

        }

        return $this->render('user/add.html.twig', [
            'controller_name' => 'UserController',
            'form' => $form->createView(),
            'users'=>$users
        ]);
    }

    /**
     * @Route("/user/delete/{email}", name="delete-user")
     */

    public function delete(User $user, Request $request, EntityManagerInterface $em): Response
    {

            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
            $this->addFlash('success', 'User deleted');
            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('user');
    }



}