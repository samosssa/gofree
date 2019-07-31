<?php

namespace App\Controller;

use App\Entity\Mission;
use App\Repository\MissionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
