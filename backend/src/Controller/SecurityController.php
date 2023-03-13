<?php

namespace App\Controller;

use App\Form\ChangePasswordFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher,
    )
    {
    }

    #[Route(path: '/', name: 'home')]
    public function home(): Response
    {

        return $this->redirectToRoute("admin");
    }

    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
         if ($this->getUser()) {
             return $this->redirectToRoute('admin');
         }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }


    #[Route('/resetUserPassword', name: 'resetUserPassword')]
    public function resetUserPassword(Request $request){
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);
        if(!password_verify($form->get('actualPassword')->getData(), $user->getPassword()) && $form->isSubmitted()){
            $form->get('plainPassword')->get('first')->addError(new FormError("Le mot de passe actuel est invalide")); //'Le mot de passe actuel est invalide'
            return $this->renderForm('security/formResetUserPassword.html.twig', [
                'form' => $form,
            ]);
        }
        if($form->isSubmitted() && $form->isValid()){
            $user = $this->getUser();
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $form->get('plainPassword')->getData()
            );
            $user->setPassword($hashedPassword);
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return $this->redirectToRoute("admin");
        }
        return $this->renderForm('security/formResetUserPassword.html.twig', [
            'form' => $form,
        ]);
    }
}
