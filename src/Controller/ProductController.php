<?php

namespace App\Controller;




use App\Entity\Artist;
use App\Entity\Categorie;
use App\Entity\Product;
use App\Repository\ArtistRepository;
use App\Repository\CategorieRepository;
use App\Repository\ProductRepository;
use App\Services\Cart;
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


    /**
     * @Route("/product/{id}", name="product_show")
     */

    public function show(ProductRepository $productRepository, CategorieRepository $categorieRepository, ArtistRepository $artistRepository,$id, Cart $cart)
    {
        $artistRepository = $this->getDoctrine()->getRepository(Artist::class);
        $products = $this->getDoctrine()->getRepository(Product::class)->findOneById($id);
        $artists = $artistRepository->findAll();
        $categories = $categorieRepository->findAll();
        // $carte = $cart->getFull();
        // redirection au cas ou il n'y a pas de produit
        if (!$products) {
            return $this->redirectToRoute('product');
        }
        // dd($product);
        // dd($carte);
        return $this->render('product/show.html.twig', [
            'product' => $products,
            'artists' => $artists,
            'categories' => $categories,
           // 'cart' => $carte
        ]);
    }

}
