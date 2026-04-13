<?php
// src/Controller/EtablissementController.php
namespace App\Controller;

use App\Repository\EtablissementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EtablissementController extends AbstractController
{
    #[Route('/etablissements', name: 'app_etablissements')]
    public function index(EtablissementRepository $etablissementRepository): Response
    {
        return $this->render('front/etablissement/index.html.twig', [
            'etablissements' => $etablissementRepository->findBy([], ['nom' => 'ASC']),
        ]);
    }
}
