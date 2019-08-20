<?php

namespace App\Controller;

use App\Entity\Mission;
use App\Form\MissionType;
use App\Repository\MissionRepository;
use App\Service\PaginationService;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminMissionController extends AbstractController
{
    /**
 * @Route("/admin/missions/{page<\d+>?1}", name="admin_mission_index")
 */
    public function index(MissionRepository $repo, $page, PaginationService $pagination)
    {
       $pagination->setPage($page);
        $pagination->setEntityClass(Mission::class);


       return $this->render('admin/ad/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * Permet d'affciher le formulaire d'edition pour l'admin
     *
     * @Route("/admin/missions/{id}/edit", name="admin_miss_edit")
     *
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
        return $this->render('admin/ad/edit.html.twig', [
            'form' => $form->createView(),
            'miss' => $mission
        ]);

    }

    /**
     * Permet de supprimer une mission
     *
     * @Route("/admin/missions/{id}/delete", name="admin_miss_delete")
     * @param Mission $mission
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(Mission $mission, ObjectManager $manager){

        if(count($mission->getApplies()) > 0) {
            $this->addFlash(
                'warning',
                "Vous ne pouvez pas supprimer la mission<strong>{$mission->getTitle()}</strong> car elle possède des candidatures!"
            );

        } else {
            $manager->remove($mission);
            $manager->flush();

            $this->addFlash(
                'success',
                "La mission<strong>{$mission->getTitle()}</strong> a bien été supprimer!"
            );
        }
        return $this->redirectToRoute('admin_mission_index');
    }

}
