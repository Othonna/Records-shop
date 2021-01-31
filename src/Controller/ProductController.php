<?php

namespace App\Controller;



use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class ProductController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/product", name="product")
     */
    public function products(): Response
    {
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();

        // dd($products);

        return $this->render('product/index.html.twig', [
            'products' => $products
        ]);
    }

}
