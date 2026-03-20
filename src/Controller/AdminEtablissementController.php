<?php
// src/Controller/AdminEtablissementController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminEtablissementController extends AbstractController
{
    #[Route('/admin/etablissements', name: 'admin_etablissements')]
    public function index(): Response
    {
        $etablissements = [
            ['id'=>1,'nom'=>'iPNet Institute of Technology','type'=>'École privée','ville'=>'Lomé'],
            ['id'=>2,'nom'=>'Université de Lomé','type'=>'Université publique','ville'=>'Lomé'],
            ['id'=>3,'nom'=>'ESTIM','type'=>'École de commerce','ville'=>'Lomé'],
            ['id'=>4,'nom'=>'Institut Supérieur de Technologie','type'=>'Institut technologique','ville'=>'Lomé'],
            ['id'=>5,'nom'=>'Université de Kara','type'=>'Université publique','ville'=>'Kara'],
            ['id'=>6,'nom'=>'École de Santé de Lomé','type'=>'École de santé','ville'=>'Lomé'],
        ];

        return $this->render('admin/etablissement/index.html.twig', [
            'etablissements' => $etablissements,
        ]);
    }
}
