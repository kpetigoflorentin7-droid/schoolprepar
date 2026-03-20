<?php
// src/Controller/AdminFiliereController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminFiliereController extends AbstractController
{
    #[Route('/admin/filieres', name: 'admin_filieres')]
    public function index(): Response
    {
        $filieres = [
            ['id'=>1,'nom'=>'Génie Logiciel','domaine'=>'Informatique','duree'=>'Bac+3','niveau'=>'Bac'],
            ['id'=>2,'nom'=>'Médecine Générale','domaine'=>'Santé','duree'=>'Bac+7','niveau'=>'Bac D'],
            ['id'=>3,'nom'=>'Droit des Affaires','domaine'=>'Droit','duree'=>'Bac+5','niveau'=>'Bac'],
            ['id'=>4,'nom'=>'BTS Commerce','domaine'=>'Commerce','duree'=>'Bac+2','niveau'=>'Bac'],
            ['id'=>5,'nom'=>'Réseaux & Télécoms','domaine'=>'Informatique','duree'=>'Bac+3','niveau'=>'Bac C/D'],
            ['id'=>6,'nom'=>'Data Science','domaine'=>'Informatique','duree'=>'Bac+5','niveau'=>'Bac C/D'],
            ['id'=>7,'nom'=>'Pharmacie','domaine'=>'Santé','duree'=>'Bac+5','niveau'=>'Bac D'],
            ['id'=>8,'nom'=>'Licence Finance','domaine'=>'Commerce','duree'=>'Bac+3','niveau'=>'Bac'],
        ];

        return $this->render('admin/filiere/index.html.twig', [
            'filieres' => $filieres,
        ]);
    }
}
