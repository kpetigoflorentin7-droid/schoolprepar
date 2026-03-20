<?php
// src/Controller/AdminDashboardController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminDashboardController extends AbstractController
{
    #[Route('/admin', name: 'admin_dashboard')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig', [
            'stats' => [
                'filieres'       => 48,
                'etablissements' => 20,
                'utilisateurs'   => 320,
                'conseillers'    => 15,
            ],
            'utilisateurs_recents' => [
                ['id'=>1,'nom'=>'Kofi Mensah','email'=>'kofi@example.com','role'=>'eleve','statut'=>'active'],
                ['id'=>2,'nom'=>'Amina Touré','email'=>'amina@example.com','role'=>'conseiller','statut'=>'active'],
                ['id'=>3,'nom'=>'Jean Agbodjan','email'=>'jean@example.com','role'=>'eleve','statut'=>'pending'],
                ['id'=>4,'nom'=>'Dr. Ama Kodjo','email'=>'ama@example.com','role'=>'pro','statut'=>'active'],
                ['id'=>5,'nom'=>'Superadmin','email'=>'admin@schoolprepar.tg','role'=>'admin','statut'=>'active'],
            ],
            'filieres_populaires' => [
                ['nom'=>'Génie Logiciel','domaine'=>'Informatique','nb_vues'=>412],
                ['nom'=>'Médecine','domaine'=>'Santé','nb_vues'=>389],
                ['nom'=>'Droit des Affaires','domaine'=>'Droit','nb_vues'=>276],
                ['nom'=>'BTS Commerce','domaine'=>'Commerce','nb_vues'=>241],
            ],
            'webinaires_prochains' => [
                ['titre'=>'Développement Web','date'=>'05 Avr 2026 – 10h00'],
                ['titre'=>'Sciences Médicales','date'=>'12 Avr 2026 – 10h00'],
                ['titre'=>'Cybersécurité','date'=>'15 Avr 2026 – 14h00'],
            ],
        ]);
    }
}
