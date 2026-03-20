<?php
// src/Controller/WebinaireController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WebinaireController extends AbstractController
{
    private function getData(): array
    {
        return [
            ['id'=>1,'nom'=>'Métiers du Développement Web','domaine'=>'Informatique','categorie'=>'info','mois'=>'Avr','jour'=>'05','image'=>'meeting-01.jpg','description'=>'Découvrez les opportunités dans le secteur numérique.'],
            ['id'=>2,'nom'=>'Parcours en Sciences Médicales','domaine'=>'Santé','categorie'=>'sante','mois'=>'Avr','jour'=>'12','image'=>'meeting-02.jpg','description'=>'Tout savoir sur les études de médecine et de pharmacie.'],
            ['id'=>3,'nom'=>'Cybersécurité & Réseaux','domaine'=>'Informatique','categorie'=>'info','mois'=>'Avr','jour'=>'15','image'=>'meeting-03.jpg','description'=>'Les métiers de la sécurité informatique et leurs débouchés.'],
            ['id'=>4,'nom'=>'BTS Commerce International','domaine'=>'Commerce','categorie'=>'commerce','mois'=>'Avr','jour'=>'20','image'=>'meeting-04.jpg','description'=>'Retours d\'expérience d\'anciens étudiants et professionnels.'],
            ['id'=>5,'nom'=>'Licence Banque & Finance','domaine'=>'Finance','categorie'=>'commerce','mois'=>'Avr','jour'=>'25','image'=>'meeting-02.jpg','description'=>'Comprendre les métiers de la finance et de la banque.'],
            ['id'=>6,'nom'=>'Carrières Juridiques & Judiciaires','domaine'=>'Droit','categorie'=>'droit','mois'=>'Mai','jour'=>'03','image'=>'meeting-03.jpg','description'=>'Avocats, magistrats, notaires : quels chemins emprunter ?'],
            ['id'=>7,'nom'=>'Filière Pharmacie & Biologie','domaine'=>'Santé','categorie'=>'sante','mois'=>'Mai','jour'=>'10','image'=>'meeting-01.jpg','description'=>'Débouchés et conditions d\'accès aux études de pharmacie.'],
            ['id'=>8,'nom'=>'Data Science & Intelligence Artificielle','domaine'=>'Informatique','categorie'=>'info','mois'=>'Mai','jour'=>'17','image'=>'meeting-04.jpg','description'=>'Les nouvelles filières du numérique et leurs perspectives.'],
            ['id'=>9,'nom'=>'Droit International & Organisations','domaine'=>'Droit','categorie'=>'droit','mois'=>'Mai','jour'=>'24','image'=>'meeting-02.jpg','description'=>'Carrières dans les organisations internationales et ONG.'],
        ];
    }

    #[Route('/webinaires', name: 'app_webinaires')]
    public function index(): Response
    {
        return $this->render('front/filiere/index.html.twig', [
            'filieres' => $this->getData(),
        ]);
    }

    #[Route('/webinaires/{id}', name: 'app_webinaire_show', requirements: ['id' => '\d+'])]
    public function show(int $id): Response
    {
        $all = $this->getData();
        $webinaire = null;
        foreach ($all as $w) {
            if ($w['id'] === $id) { $webinaire = $w; break; }
        }
        if (!$webinaire) {
            $webinaire = [
                'id'=>$id,'nom'=>'Webinaire #'.$id,'domaine'=>'Informatique',
                'mois'=>'N/A','jour'=>'--','image'=>'meeting-01.jpg',
                'intervenant'=>'Intervenant à définir',
                'description_longue'=>'Description à venir.',
                'duree'=>'À définir','niveau_acces'=>'À définir','debouches'=>[],
            ];
        } else {
            // Enrichir avec les détails
            $webinaire['intervenant']       = 'Animé par M. Kofi Asante – Développeur Senior | Lomé, Togo';
            $webinaire['description_longue'] = $webinaire['description'] . ' Un expert du domaine partagera son parcours et répondra à vos questions en direct.';
            $webinaire['duree']             = 'Samedi ' . $webinaire['jour'] . ' ' . $webinaire['mois'] . ' 2026 – 10h00 à 12h00 (GMT+0)';
            $webinaire['niveau_acces']      = 'Webinaire en ligne – Plateforme Zoom / SchoolPrepar Live';
            $webinaire['debouches']         = [];
            $webinaire['nom']               = $webinaire['nom'];
        }

        return $this->render('front/filiere/show.html.twig', [
            'filiere' => $webinaire,
        ]);
    }
}
