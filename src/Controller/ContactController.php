<?php

namespace App\Controller;


use App\Entity\Artist;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, EntityManagerInterface $manager): Response
    {
        $artist = new Artist();

        $form = $this->createFormBuilder($artist)
            ->add('name')
            ->getForm();

        $form->handleRequest($request);

        dump($artist);

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
