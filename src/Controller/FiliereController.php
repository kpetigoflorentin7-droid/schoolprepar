<?php
// src/Controller/FiliereController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FiliereController extends AbstractController
{
    #[Route('/filieres', name: 'app_filieres')]
    public function index(): Response
    {
        $filieres = [
            ['id'=>1,'nom'=>'Métiers du Développement Web','domaine'=>'Informatique','categorie'=>'info','mois'=>'Avr','jour'=>'05','image'=>'meeting-01.jpg','description'=>'Découvrez les opportunités dans le secteur numérique.','duree'=>'Bac+3','niveau'=>'Bac'],
            ['id'=>2,'nom'=>'Parcours en Sciences Médicales','domaine'=>'Santé','categorie'=>'sante','mois'=>'Avr','jour'=>'12','image'=>'meeting-02.jpg','description'=>'Tout savoir sur les études de médecine et pharmacie.','duree'=>'Bac+7','niveau'=>'Bac'],
            ['id'=>3,'nom'=>'Cybersécurité & Réseaux','domaine'=>'Informatique','categorie'=>'info','mois'=>'Avr','jour'=>'15','image'=>'meeting-03.jpg','description'=>'Les métiers de la sécurité informatique.','duree'=>'Bac+3','niveau'=>'Bac'],
            ['id'=>4,'nom'=>'BTS Commerce International','domaine'=>'Commerce','categorie'=>'commerce','mois'=>'Avr','jour'=>'20','image'=>'meeting-04.jpg','description'=>'Retours d\'expérience de professionnels.','duree'=>'Bac+2','niveau'=>'Bac'],
            ['id'=>5,'nom'=>'Licence Banque & Finance','domaine'=>'Finance','categorie'=>'commerce','mois'=>'Avr','jour'=>'25','image'=>'meeting-02.jpg','description'=>'Comprendre les métiers de la finance.','duree'=>'Bac+3','niveau'=>'Bac'],
            ['id'=>6,'nom'=>'Carrières Juridiques & Judiciaires','domaine'=>'Droit','categorie'=>'droit','mois'=>'Mai','jour'=>'03','image'=>'meeting-03.jpg','description'=>'Avocats, magistrats, notaires : quels chemins ?','duree'=>'Bac+5','niveau'=>'Bac'],
            ['id'=>7,'nom'=>'Filière Pharmacie & Biologie','domaine'=>'Santé','categorie'=>'sante','mois'=>'Mai','jour'=>'10','image'=>'meeting-01.jpg','description'=>'Débouchés et conditions d\'accès en pharmacie.','duree'=>'Bac+5','niveau'=>'Bac'],
            ['id'=>8,'nom'=>'Data Science & Intelligence Artificielle','domaine'=>'Informatique','categorie'=>'info','mois'=>'Mai','jour'=>'17','image'=>'meeting-04.jpg','description'=>'Les nouvelles filières du numérique.','duree'=>'Bac+5','niveau'=>'Bac'],
            ['id'=>9,'nom'=>'Droit International & Organisations','domaine'=>'Droit','categorie'=>'droit','mois'=>'Mai','jour'=>'24','image'=>'meeting-02.jpg','description'=>'Carrières dans les organisations internationales.','duree'=>'Bac+5','niveau'=>'Bac'],
        ];

        return $this->render('front/filiere/index.html.twig', [
            'filieres' => $filieres,
        ]);
    }

    #[Route('/filieres/{id}', name: 'app_filiere_show', requirements: ['id' => '\d+'])]
    public function show(int $id): Response
    {
        // Données fictives – sera remplacé par Doctrine en TP3
        $filieres = [
            1 => [
                'id'               => 1,
                'nom'              => 'Métiers du Développement Web',
                'domaine'          => 'Informatique & Numérique',
                'mois'             => 'Avr',
                'jour'             => '05',
                'image'            => 'single-meeting.jpg',
                'intervenant'      => 'Animé par M. Kofi Asante – Développeur Senior chez TechAfrique | Lomé, Togo',
                'description_longue' => 'Ce webinaire présente les différents métiers liés au développement web : développeur front-end, back-end, full-stack, DevOps, UX/UI designer. Vous découvrirez les filières adaptées (Licence Informatique, BTS Développement Web, Master Web & Mobile), les conditions d\'admission, ainsi que les débouchés professionnels en Afrique et à l\'international.',
                'duree'            => 'Bac+3 à Bac+5',
                'niveau_acces'     => 'Baccalauréat (série C, D ou équivalent)',
                'debouches'        => ['Développeur Web / Mobile','Chef de projet IT','DevOps Engineer','UX/UI Designer','Architecte logiciel'],
            ],
            2 => [
                'id'               => 2,
                'nom'              => 'Parcours en Sciences Médicales',
                'domaine'          => 'Santé & Médecine',
                'mois'             => 'Avr',
                'jour'             => '12',
                'image'            => 'meeting-02.jpg',
                'intervenant'      => 'Dr. Ama Kodjo – Médecin généraliste | Lomé, Togo',
                'description_longue' => 'Tout savoir sur les études de médecine et de pharmacie. Conditions d\'admission, durée des études, spécialités disponibles et débouchés au Togo et en Afrique.',
                'duree'            => 'Bac+7 (Médecine) / Bac+5 (Pharmacie)',
                'niveau_acces'     => 'Baccalauréat série D obligatoire',
                'debouches'        => ['Médecin généraliste','Pharmacien','Chirurgien','Biologiste médical'],
            ],
        ];

        $filiere = $filieres[$id] ?? [
            'id'               => $id,
            'nom'              => 'Filière #' . $id,
            'domaine'          => 'Non défini',
            'mois'             => 'N/A',
            'jour'             => '--',
            'image'            => 'meeting-01.jpg',
            'intervenant'      => 'Intervenant à définir',
            'description_longue' => 'Description complète de cette filière à venir.',
            'duree'            => 'À définir',
            'niveau_acces'     => 'À définir',
            'debouches'        => [],
        ];

        return $this->render('front/filiere/show.html.twig', [
            'filiere' => $filiere,
        ]);
    }
}
