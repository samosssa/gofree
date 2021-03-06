<?php

namespace App\Controller;

use App\Entity\Mission;
use App\Entity\PasswordUpdate;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\UserSoc;
use App\Form\AccountType;
use App\Form\MissionType;
use App\Form\PasswordUpdateType;
use App\Form\RegistrationSocType;
use App\Form\RegistrationType;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountController extends AbstractController
{
    /**
     * Permet de se connecter
     *
     * @Route("/login", name="account_login")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login(AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();

        return $this->render('account/login.html.twig', [
            'hasError' => $error !== null,
            'username' => $username
        ]);
    }

    /**
     * Permet de se deconnecter
     *
     * @Route("/logout", name="account_logout")
     *
     * @return void
     */
    public function logout()
    {
        //rien...
    }

    /**
     * Permet d'afficher la page de choix
     *
     * @Route("/account/choice", name="account_choice")
     *
     *
     */
    public function choice(){
        return $this->render('account/choice.html.twig');
    }

    /**
     * Permet de afficher le formulaire d inscription
     *
     * @Route("/register", name="account_register")
     */
    public function register(Request $request, ObjectManager $manager, UserPasswordEncoderInterface$encoder){

        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $hash = $encoder->encodePassword($user, $user->getHash());
            $user->setHash($hash);
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "Votre compte a bien été créé ! Vous pouvez maintenant vous connecter"
            );

            return $this->redirectToRoute('account_login');


        }

        return $this->render('account/registration.html.twig', [
            'form' => $form->createView()

        ]);

    }/**
 * Permet de afficher le formulaire d inscription d'un utilisateur société
 *
 * @Route("/registersoc", name="account_registersoc")
 */
    public function registersoc(Request $request, ObjectManager $manager, UserPasswordEncoderInterface$encoder){

        $usersoc = new UserSoc();



        $form = $this->createForm(RegistrationSocType::class, $usersoc);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $usersocRole = new Role();
            $usersocRole ->setTitle('ROLE_USERSOC');
            $manager->persist($usersocRole);

            $hash = $encoder->encodePassword($usersoc, $usersoc->getHash());
            $usersoc->setHash($hash)
                    ->addRole($usersocRole);
            $manager->persist($usersoc);
            $manager->flush();

            $this->addFlash(
                'success',
                "Votre compte a bien été créé ! Vous pouvez maintenant vous connecter"
            );

            return $this->redirectToRoute('account_login');


        }

        return $this->render('account/registration.html.twig', [
            'form' => $form->createView()

        ]);

    }




    /**
     * Permet d afficher et de traiter le formulaire de modification du profil
     *
     * @Route("/account/profile", name="account_profile")
     *
     * @IsGranted("ROLE_USER")
     *
     * @return Response
     */
    public function profile(Request $request, ObjectManager $manager){

        $user = $this->getuser();

        $form = $this->createForm(AccountType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "Les données du profile ont bien été enregistrées"
            );
        }

        return $this->render('account/profile.html.twig', [
            'form' =>$form->createView()
        ]);

    }
    /**
     * Permet d afficher et de traiter le formulaire de modification du profil soc
     *
     * @Route("/account/profile", name="account_profile")
     *
     * @IsGranted("ROLE_USERSOC")
     *
     * @return Response
     */
    public function profilesoc(Request $request, ObjectManager $manager){

        $user = $this->getuser();

        $form = $this->createForm(RegistrationSocType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "Les données du profile ont bien été enregistrées"
            );
        }

        return $this->render('account/profilesoc.html.twig', [
            'form' =>$form->createView()
        ]);

    }

    /**
     * Permet de modifier  mot de passe
     *
     * @Route("/account/password-update", name="account_password")
     *
     * @IsGranted("ROLE_USER")
     *
     * @return Response
     */
    public function  updatePassword(Request $request, UserPasswordEncoderInterface $encoder, ObjectManager $manager)
    {

        $passwordUpdate = new PasswordUpdate();

        $user = $this->getUser();

        $form = $this->createForm(PasswordUpdateType::class, $passwordUpdate);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //1. Vériffier que le oldPassword du formulaire soit le meme que le pasword de l'user
            if (!password_verify($passwordUpdate->getOldPassword(), $user->getHash())) {
                // Gérer l'erreur

                $form->get('oldPassword')->addError(new FormError("Le mot de passe que vous avez tappé n'est pas votre mot de passe actuel"));
            } else {

                $newPassword = $passwordUpdate->getNewPassword();
                $hash = $encoder->encodePassword($user, $newPassword);

                $user->setHash($hash);

                $manager->persist($user);
                $manager->flush();

                $this->addFlash(
                    'success',
                    "Votre mot de passe a bien été modifié!"
                );

                return $this->redirectToRoute('home');
            }
        }


        return $this->render('account/password.html.twig', [

            'form' => $form->createView()

        ]);

    }


    /**
     * Permet d afficher le profile de l'utilisateur connecté
     *
     * @Route("/account", name="account_index")
     *
     * @IsGranted("ROLE_USER")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function myAccount(){

        return $this->render('user/index.html.twig', [
            'user' => $this->getUser()
        ]);

    }


    /**
     * Permet d'afficher la liste des candidature envoyé faites par le freelancer
     *
     * @Route("/account/applies", name="account_applies")
     *
     */
public function bookings(){
        return $this->render('account/applies.html.twig');
}


    /**
     * Permet d afficher le profile de l'utilisateur connecté
     *
     * @Route("/accountsoc", name="accountsoc_index")
     *
     * @IsGranted("ROLE_USERSOC")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function myAccountsoc(){

        return $this->render('user_soc/index.html.twig', [
            'usersoc' => $this->getUser()
        ]);

    }




}
