<?php
// src/Controller/HomeController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('front/home.html.twig', [
            'stats' => [
                'filieres'       => '1 200',
                'etablissements' => '350',
                'conseillers'    => '80',
                'eleves'         => '4 500',
            ],
            'webinaires' => [
                ['id'=>1,'titre'=>'Métiers du Développement Web','domaine'=>'Informatique','mois'=>'Avr','jour'=>'05','image'=>'meeting-01.jpg','description'=>'Découvrez les opportunités dans le secteur numérique.'],
                ['id'=>2,'titre'=>'Parcours en Sciences Médicales','domaine'=>'Santé','mois'=>'Avr','jour'=>'12','image'=>'meeting-02.jpg','description'=>'Tout savoir sur les études de médecine.'],
                ['id'=>3,'titre'=>'Cybersécurité & Réseaux','domaine'=>'Informatique','mois'=>'Avr','jour'=>'15','image'=>'meeting-03.jpg','description'=>'Les métiers de la sécurité informatique.'],
                ['id'=>4,'titre'=>'BTS Commerce International','domaine'=>'Commerce','mois'=>'Avr','jour'=>'20','image'=>'meeting-04.jpg','description'=>'Retours d\'expérience de professionnels.'],
            ],
            'filieres_vedettes' => [
                ['nom'=>'Génie Logiciel','image'=>'course-01.jpg','etoiles'=>4,'niveau'=>'Bac+3'],
                ['nom'=>'BTS Comptabilité & Gestion','image'=>'course-02.jpg','etoiles'=>4,'niveau'=>'Bac+2'],
                ['nom'=>'Licence Droit des Affaires','image'=>'course-03.jpg','etoiles'=>5,'niveau'=>'Bac+3'],
                ['nom'=>'Master Génie Civil','image'=>'course-04.jpg','etoiles'=>4,'niveau'=>'Bac+5'],
                ['nom'=>'Études de Médecine','image'=>'course-01.jpg','etoiles'=>5,'niveau'=>'Bac+7'],
            ],
        ]);
    }
}
