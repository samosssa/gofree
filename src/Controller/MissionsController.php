<?php

namespace App\Controller;

use App\Entity\Category;
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
     * permet de créer une nouvelle annnonce
     * @Route("/missions/new", name="miss_create")
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function create(Request $request,ObjectManager $manager){

        $mission = new Mission();

        $cats= $this->getDoctrine()->getRepository(Category::class)->findAll();
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
            'form' => $form->createView(),
            'category' => $cats,
        ]);
    }

    /**
     * Permet d'affciher le formulaire d'edition
     *
     * @Route("/missions/{slug}/edit", name="miss_edit")
     * @Security("is_granted('ROLE_USER') and user === mission.getAuthor()")
     */
    public function edit(Mission $mission, Request $request, ObjectManager $manager){

        $form = $this->createForm(MissionType::class, $mission);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager ->persist($mission);
            $manager->flush();
            $this->addFlash(
                'success',
                "La mission <strong>{$mission->getTitle()}</strong> a bien été modifier!"
            );
            return $this->redirectToRoute('mission_show', [
                'slug' => $mission->getSlug()
            ]);
        }
        return $this->render('missions/edit.html.twig', [
            'form' => $form->createView(),
            'miss' => $mission
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
     * Permet de supprimer un annonce
     *
     * @Route("/missions/{slug}/delete", name="miss_delete")
     * @param Mission $mission
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(Mission $mission, ObjectManager $manager){

    }





}
