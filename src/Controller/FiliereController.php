<?php
// src/Controller/FiliereController.php
namespace App\Controller;

use App\Entity\Filiere;
use App\Repository\FiliereRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FiliereController extends AbstractController
{
    #[Route('/filieres', name: 'app_filieres')]
    public function index(FiliereRepository $filiereRepository): Response
    {
        return $this->render('front/filiere/index.html.twig', [
            'filieres' => $filiereRepository->findBy([], ['nom' => 'ASC']),
        ]);
    }

    #[Route('/filieres/{id}', name: 'app_filiere_show', requirements: ['id' => '\d+'])]
    public function show(Filiere $filiere): Response
    {
        return $this->render('front/filiere/show.html.twig', [
            'filiere' => $filiere,
        ]);
    }
}
