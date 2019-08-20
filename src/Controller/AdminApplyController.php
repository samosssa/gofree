<?php

namespace App\Controller;

use App\Entity\Apply;
use App\Repository\ApplyRepository;
use App\Service\PaginationService;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminApplyController extends AbstractController
{
    /**
     * @Route("/admin/applies/{page<\d+>?1}", name="admin_apply")
     */
    public function index(ApplyRepository $repo, $page, PaginationService $pagination)
    {

        $pagination->setPage($page);
        $pagination->setEntityClass(Apply::class);


        return $this->render('admin/apply/index.html.twig', [
            'pagination' => $pagination
        ]);
    }


    /**
     * Permet de supprimer une candidature
     *
     * @Route("/admin/applies/{id}/delete", name="admin_apply_delete")
     * @param Apply $apply
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(Apply $apply, ObjectManager $manager)
    {


        $manager->remove($apply);
        $manager->flush();

        $this->addFlash(
            'success',
            "La candidature<strong>{$apply->getId()}</strong> a bien été supprimer!"
        );

        return $this->redirectToRoute('admin_apply');
    }

}
