<?php
// src/Controller/FiliereController.php
namespace App\Controller;

use App\Entity\Filiere;
use App\Repository\FiliereRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FiliereController extends AbstractController
{
    private const FILIERES_PER_PAGE = 10;

    #[Route('/filieres', name: 'app_filieres')]
    public function index(Request $request, FiliereRepository $filiereRepository): Response
    {
        $page = max(1, (int) $request->query->get('page', 1));
        $result = $filiereRepository->findPageOrderedByNom($page, self::FILIERES_PER_PAGE);
        $total = $result['total'];
        $totalPages = max(1, (int) ceil($total / self::FILIERES_PER_PAGE));

        if ($page > $totalPages && $total > 0) {
            return $this->redirectToRoute('app_filieres', ['page' => $totalPages]);
        }

        return $this->render('front/filiere/index.html.twig', [
            'filieres' => $result['items'],
            'item_show_route' => 'app_filiere_show',
            'pagination_route' => 'app_filieres',
            'pagination' => [
                'page' => min($page, $totalPages),
                'perPage' => self::FILIERES_PER_PAGE,
                'total' => $total,
                'totalPages' => $totalPages,
            ],
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
