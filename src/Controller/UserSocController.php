<?php

namespace App\Controller;

use App\Entity\UserSoc;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserSocController extends AbstractController
{
    /**
     * @Route("/usersoc/{slug}", name="usersoc_show")
     */
    public function index(UserSoc $usersoc)
    {
        return $this->render('user_soc/index.html.twig', [
            'usersoc' => $usersoc
        ]);
    }
}
