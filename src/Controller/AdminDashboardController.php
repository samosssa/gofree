<?php

namespace App\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashboardController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_dashboard")
     */
    public function index(ObjectManager $manager)
    {
        $users = $manager->createQuery('SELECT COUNT(u) FROM App\Entity\User u')->getSingleScalarResult();
        $missions = $manager->createQuery('SELECT COUNT(m) FROM App\Entity\Mission m')->getSingleScalarResult();
        $applies = $manager->createQuery('SELECT COUNT(a) FROM App\Entity\User a')->getSingleScalarResult();


        return $this->render('admin/dashboard/index.html.twig', [
            'stats' => compact('users','missions', 'applies')
            ]);
    }
}
