<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    /**
     * @Route("/inscription", name="register")
     */
    public function register(Request $request, EntityManagerInterface $manager): Response
    {
        // dump($request);
        $user = new User();

        $form = $this->createFormBuilder($user)
                     ->add('firstname')
                     ->add('lastname')
                     ->add('email')
                     ->add('password')
                     ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('home', ['id' => $user->getId()]);
        }

        dump($user);

        return $this->render('register/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
