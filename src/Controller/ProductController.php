<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\User;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="product")
     */
    public function index(Request $request): Response
    {
        $product = new Product();

        $searchfor = $request->query->get('searchfor');
        if ($searchfor) {
            $products = $this->getDoctrine()->getRepository(Product::class)->findBy(['name' => $searchfor]);
        } else {
            $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
        }

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
            $this->addFlash('success', 'Product added');
            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('products');
        }
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
            'form' => $form->createView(),
            'products' => $products,
            'searchfor' => $searchfor
        ]);
    }


    /**
     * @Route("/products/{orderBy}/{order}/{limit}", name="products")
     */
    public function list(Request $request, string $orderBy = 'name', string $order = 'asc', int $limit = 100): Response
    {
        $product = new Product();
        $searchfor = $request->query->get('searchfor');
        $products = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findBy([], [$orderBy => $order], $limit);

        return $this->render('product/list.html.twig', [
            'controller_name' => 'ProductController',
            'products' => $products,
            'searchfor' => $searchfor
        ]);
    }
    /**
     * @Route("/product/edit/{id}", name="productedit")
     */

    public function edit(Product $product, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
            $this->addFlash('success', 'Product edited');
            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('products');
        }
        return $this->render('product/edit.html.twig', [
            'controller_name' => 'ProductController',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/product/add", name="product-add")
     */
    public function add(Request $request): Response
    {
        $product = new Product();
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
            $this->addFlash('success', 'Product added');
            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('products');
        }
        return $this->render('product/add.html.twig', [
            'controller_name' => 'ProductController',
            'form' => $form->createView(),
            'products' => $products
        ]);
    }
    /**
     * @Route("/product/delete/{id}", name="delete-product")
     */

    public function delete(Product $product, Request $request, EntityManagerInterface $em): Response
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($product);
        $em->flush();
        $this->addFlash('success', 'User deleted');
        // ... perform some action, such as saving the task to the database

        return $this->redirectToRoute('products');
    }
}
