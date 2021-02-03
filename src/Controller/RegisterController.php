<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints\Length;

class RegisterController extends AbstractController
{
    private $entitymanager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entitymanager = $entityManager;
    }

    /**
     * @Route("/inscription", name="register")
     */
    public function register(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder): Response
    {
        // dump($request);
        $user = new User();

        $form = $this->createFormBuilder($user)
                     ->add('firstname', TextType::class, array('constraints' => new Length (['min' => 2, 'max' => 15])))
                     ->add('lastname', TextType::class, array('constraints' => new Length (['min' => 2, 'max' => 15])))
                     ->add('email')
                     ->add('password', PasswordType::class, array('label' => 'Password', 'constraints' => new Length(['min' => 2, 'max' => 30])))
                     ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $user =$form->getData();

            // On encode (criptage) de notre password grâce à l'injection de dépendance UserPasswordEncoder
            $password = $encoder->encodePassword($user, $user->getPassword());

            // on l'injecte dans user entity
            $user->setPassword($password);
            //dd($password);

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('home', ['id' => $user->getId()]);
        }

        //dump($user);

        return $this->render('register/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
