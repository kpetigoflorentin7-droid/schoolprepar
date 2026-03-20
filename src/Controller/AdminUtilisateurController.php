<?php
// src/Controller/AdminUtilisateurController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminUtilisateurController extends AbstractController
{
    #[Route('/admin/utilisateurs', name: 'admin_utilisateurs')]
    public function index(): Response
    {
        $utilisateurs = [
            ['id'=>1,'nom'=>'Kofi Mensah','email'=>'kofi@example.com','role'=>'eleve','statut'=>'active','date'=>'12/03/2026'],
            ['id'=>2,'nom'=>'Amina Touré','email'=>'amina@example.com','role'=>'conseiller','statut'=>'active','date'=>'10/03/2026'],
            ['id'=>3,'nom'=>'Jean Agbodjan','email'=>'jean@example.com','role'=>'eleve','statut'=>'pending','date'=>'15/03/2026'],
            ['id'=>4,'nom'=>'Dr. Ama Kodjo','email'=>'ama@example.com','role'=>'pro','statut'=>'active','date'=>'05/03/2026'],
            ['id'=>5,'nom'=>'Superadmin','email'=>'admin@schoolprepar.tg','role'=>'admin','statut'=>'active','date'=>'01/01/2026'],
            ['id'=>6,'nom'=>'Tété Aklesso','email'=>'tete@example.com','role'=>'eleve','statut'=>'inactive','date'=>'08/03/2026'],
            ['id'=>7,'nom'=>'Mawuena Dossou','email'=>'mawuena@example.com','role'=>'eleve','statut'=>'active','date'=>'17/03/2026'],
        ];

        return $this->render('admin/utilisateur/index.html.twig', [
            'utilisateurs' => $utilisateurs,
        ]);
    }
}
