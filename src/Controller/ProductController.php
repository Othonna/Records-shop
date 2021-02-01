<?php

namespace App\Controller;




use App\Entity\Artist;
use App\Entity\Categorie;
use App\Entity\Product;
use App\Repository\ArtistRepository;
use App\Repository\CategorieRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class ProductController extends AbstractController
{

    /**
     * @Route("/product", name="product")
     */
    public function products(ProductRepository $productRepository, CategorieRepository $categorieRepository, ArtistRepository $artistRepository): Response
    {
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $categorieRepository = $this->getDoctrine()->getRepository(Categorie::class);
        $artistRepository = $this->getDoctrine()->getRepository(Artist::class);
        $products = $productRepository->findAll();
        $favorite = $productRepository->filterFavorite();
        $categories = $categorieRepository->findAll();
        $artists = $artistRepository->findAll();

        //dump($categories);
        return $this->render('product/index.html.twig', [
            'products' => $products,
            'favorites' => $favorite,
            'categories' => $categories,
            'artists' => $artists,
        ]);
    }



}
