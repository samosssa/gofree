<?php

namespace App\Controller;

use App\Entity\Apply;
use App\Entity\Mission;
use App\Form\ApplicationType;
use App\Form\ApplyType;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApplyController extends AbstractController
{
    /**
     * @Route("/missionss/{slug}/apply", name="apply_create")
     * @IsGranted("ROLE_USER")
     */
    public function book(Mission $mission, Request $request, ObjectManager $manager)
    {
        $apply = new Apply();
        $form = $this->createForm(ApplyType::class, $apply);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user = $this->getUser();

            $apply->setFreelancer($user)
                ->setMission($mission)
                ->setStartDate($mission->getStartDay())
                ->setEndDate($mission->getEndDate())
                ->setAmount($mission->getPrice());


            $manager->persist($apply);
            $manager->flush();

            return $this->redirectToRoute('apply_show', ['id' => $apply->getId()]);
        }

        return $this->render('apply/apply.html.twig', [
            'miss' => $mission,
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet d'afficher la page d'une réservation
     *
     * @Route("/apply/{id}", name="apply_show")
     *
     * @param Apply $apply
     * @return Response
     */
    public function show(Apply $apply){

        return $this->render('apply/show.html.twig', [
            'apply' => $apply
        ]);
    }
}
