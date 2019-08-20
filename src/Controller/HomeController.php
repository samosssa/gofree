<?php

namespace App\Controller;

use App\Repository\MissionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(MissionRepository $missrepo)
    {
        return $this->render('home/index.html.twig', [
            'miss' => $missrepo->findRecentMiss(6),
        ]);
    }
}
