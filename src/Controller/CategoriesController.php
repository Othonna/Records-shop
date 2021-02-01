<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesController extends AbstractController
{
    /**
     * @Route("/categories", name="categories")
     */
    public function index(ProductRepository $repository): Response

    {
        $repository = $this->getDoctrine()->getRepository(Categorie::class);
        $categories = $repository->getCategories();

        dump($categories);
        return $this->render('categories/index.html.twig', [
            'categories' => $categories,
        ]);
    }
}
