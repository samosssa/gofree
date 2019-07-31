<?php

namespace App\Controller;

use App\Entity\Mission;
use App\Entity\User;
use App\Form\MissionType;
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

    }

    /**
     * //permet de créer une nouvelle annnonce
     *
     * @Route("/missions/new", name="missions_create")
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function create(Request $request,ObjectManager $manager){

        $mission = new Mission();




        $form = $this->createForm(MissionType::class, $mission);
        $form->handleRequest($request);



        if($form->isSubmitted() && $form->isValid()){

            $mission->setAuthor($this->getUser());
            $manager ->persist($mission);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'annonce <strong>{$ad->getTitle()}</strong> a bien été enregistrée!"
            );



            return $this->redirectToRoute('ads_show', [
                'slug' => $ad->getSlug()

            ]);
        }


        return $this->render('missions/new.html.twig', [
            'form' => $form->createView()
        ]);
    }


}
