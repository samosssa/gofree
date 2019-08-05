<?php

namespace App\Controller;

use App\Entity\Mission;
use App\Form\MissionType;
use App\Repository\MissionRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MissionsController extends AbstractController
{
    /**
     * @Route("/missions", name="missions_index")
     */
    public function index(MissionRepository $repo)
    {
        //$repo = $this->getDoctrine()->getRepository(Ad::class);
        $mission = $repo->findAll();

        return $this->render('missions/index.html.twig', [
            'missions' => $mission
        ]);
    }



    /**
     * @Route("/missions/{slug}", name="mission_show")
     *
     * @return Response
     */
    public function show(Mission $miss){

        return $this->render('missions/show.html.twig', [
            'miss' => $miss
        ]);
    }

    /**
     * permet de créer une nouvelle annnonce
     * @Route("/missions/new", name="miss_create")
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
                    "La mission <strong>{$mission->getTitle()}</strong> a bien été enregistrée!"
                );

                return $this->redirectToRoute('mission_show', [
                    'slug' => $mission->getSlug()
                ]);
            }
        return $this->render('missions/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet d'affciher le formulaire d'edition
     *
     * @Route("/ads/{slug}/edit", name="ads_edit")
     * @Security("is_granted('ROLE_USER') and user === ad.getAuthor()")
     */
    public function edit(Mission $mission, Request $request, ObjectManager $manager){

        $form = $this->createForm(MissionType::class, $ad);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager ->persist($ad);
            $manager->flush();
            $this->addFlash(
                'success',
                "L'annonce <strong>{$ad->getTitle()}</strong> a bien été modifier!"
            );
            return $this->redirectToRoute('ads_show', [
                'slug' => $ad->getSlug()
            ]);
        }
        return $this->render('ad/edit.html.twig', [
            'form' => $form->createView(),
            'ad' => $ad
        ]);

    }





}
