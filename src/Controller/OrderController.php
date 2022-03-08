<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityRepository;

class OrderController extends AbstractController
{
    /**
     * @Route("/order/filter/{startBy}/{endBy}", name="orders-by-dates")
     */


    public function dateSort(string $startBy  = '01-01-2017', string $endBy = '01-01-19'): Response
    {

        //$orderr = new Order();
                $orders = $this->getDoctrine()
            ->getRepository(Order::class)
            ->findByDate($startBy, $endBy);

        return $this->render('order/index.html.twig', [
            'controller_name' => 'OrderController',
            'orders'=>$orders
        ]);
    }

    /**
     * @Route("/order", name="order")
     */
    public function index(Request $request): Response
    {
        $order = new Order();
        $orders = $this->getDoctrine()->getRepository(Order::class)->findAll();

        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($order);
            $em->flush();
            $this->addFlash('success', 'Order added');
            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('order');
        }
        return $this->render('order/index.html.twig', [
            'controller_name' => 'OrderController',
            'form' => $form->createView(),
            'orders'=>$orders
        ]);
    }


    /**
     * @Route("/order/add", name="order-add")
     */
    public function add(Request $request): Response
    {
        $order = new Order();
        $orders = $this->getDoctrine()->getRepository(Order::class)->findAll();

        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($order);
            $em->flush();
            $this->addFlash('success', 'Order added');
            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('order');
        }
        return $this->render('order/add.html.twig', [
            'controller_name' => 'OrderController',
            'form' => $form->createView(),
            'orders'=>$orders
        ]);
    }


    /**
     * @Route("/order/edit/{id}", name="orderedit")
     */

    public function edit(Order $order, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($order);
            $em->flush();
            $this->addFlash('success', 'Order edited');
            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('order');
        }
        return $this->render('order/edit.html.twig', [
            'controller_name' => 'OrderController',
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/order/delete/{id}", name="delete-order")
     */

    public function delete(Order $order, Request $request, EntityManagerInterface $em): Response
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($order);
        $em->flush();
        $this->addFlash('success', 'Order deleted');
        // ... perform some action, such as saving the task to the database

        return $this->redirectToRoute('order');
    }

    /**
     * @Route("/order/filter/{orderBy}/{order}/{limit}", name="order-list")
     */


    public function list(string $orderBy  = 'saler', string $order = 'asc', int $limit = 100): Response
    {

        //$orderr = new Order();
        $orders = $this->getDoctrine()
            ->getRepository(Order::class)
            ->findBy([], [$orderBy => $order], $limit);

        return $this->render('order/index.html.twig', [
            'controller_name' => 'OrderController',
            'orders'=>$orders
        ]);
    }



}
