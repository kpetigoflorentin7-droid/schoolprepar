<?php
// src/Controller/EtablissementController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EtablissementController extends AbstractController
{
    #[Route('/etablissements', name: 'app_etablissements')]
    public function index(): Response
    {
        $etablissements = [
            [
                'id'          => 1,
                'nom'         => 'iPNet Institute of Technology',
                'type'        => 'École privée',
                'ville'       => 'Lomé',
                'description' => 'Institut spécialisé en informatique, réseaux et développement web.',
                'filieres'    => ['Génie Logiciel','Réseaux & Télécoms','Cybersécurité'],
            ],
            [
                'id'          => 2,
                'nom'         => 'Université de Lomé',
                'type'        => 'Université publique',
                'ville'       => 'Lomé',
                'description' => 'La plus grande université du Togo, offrant des formations pluridisciplinaires.',
                'filieres'    => ['Médecine','Droit','Informatique','Sciences'],
            ],
            [
                'id'          => 3,
                'nom'         => 'ESTIM',
                'type'        => 'École de commerce',
                'ville'       => 'Lomé',
                'description' => 'École supérieure spécialisée en management, finance et commerce.',
                'filieres'    => ['BTS Commerce','Licence Management','MBA Finance'],
            ],
            [
                'id'          => 4,
                'nom'         => 'Institut Supérieur de Technologie',
                'type'        => 'Institut technologique',
                'ville'       => 'Lomé',
                'description' => 'Formation en génie civil, électronique et mécanique.',
                'filieres'    => ['Génie Civil','Électronique','Mécanique'],
            ],
            [
                'id'          => 5,
                'nom'         => 'Université de Kara',
                'type'        => 'Université publique',
                'ville'       => 'Kara',
                'description' => 'Université du nord du Togo avec des filières variées.',
                'filieres'    => ['Droit','Lettres','Sciences économiques'],
            ],
            [
                'id'          => 6,
                'nom'         => 'École de Santé de Lomé',
                'type'        => 'École de santé',
                'ville'       => 'Lomé',
                'description' => 'Formation des professionnels de santé : infirmiers, sages-femmes, techniciens.',
                'filieres'    => ['Soins infirmiers','Sage-femme','Technicien médical'],
            ],
        ];

        return $this->render('front/etablissement/index.html.twig', [
            'etablissements' => $etablissements,
        ]);
    }
}
