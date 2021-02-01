<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
     public function home(ProductRepository $repository): Response
     {
         $repository =$this->getDoctrine()->getRepository(Product::class);
         $products = $repository->filterDate();
         $favorite = $repository->filterFavorite();
         $randView = $repository->randView();


         return $this->render('index/index.html.twig', [
             'products' => $products,
             'favorites' => $favorite,
             'randViews' => $randView
         ]);
     }

}
