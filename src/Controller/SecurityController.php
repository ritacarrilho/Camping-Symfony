<?php

namespace App\Controller;

use App\Form\RegistrationType;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
     /**
     * @var
     */
    private $pass_hasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->pass_hasher = $passwordHasher;
    }
    /**
     * @Route("/admin/subscription", name="security_registration")
     */
    public function registration(Request $request, ManagerRegistry $manager, UserPasswordHasherInterface $pass_hasher) {
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user); // bind the form and user
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            // encode password before saving into DB
            $user->setPassword($this->pass_hasher->hashPassword($user, $user->getPassword()));
            
            $em = $manager->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'You have created a new user account.');
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/login", name="security_login")
     * @return void
     */
    public function login(AuthenticationUtils $authenticationUtils) {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUser = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'lastUser' => $lastUser,
            'error' => $error
        ]);
    }

    /**
     * @Route("/logout", name="security_logout")
     * @return void
     */
    public function logout()
    {
        $this->redirectToRoute("app_home");
    }

}
