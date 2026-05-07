<?php
namespace App\Controller;

use App\Entity\RendezVous;
use App\Form\RendezVousType;
use App\Repository\RendezVousRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/rendez-vous')]
#[IsGranted('ROLE_ADMIN')]
class AdminRendezVousController extends AbstractController
{
    private const PER_PAGE = 10;

    #[Route('/', name: 'admin_rdv', methods: ['GET'])]
    public function index(Request $request, RendezVousRepository $repo): Response
    {
        $conn = $repo->getEntityManager()->getConnection();

        $page       = max(1, (int) $request->query->get('page', 1));
        $total      = (int) $conn->executeQuery('SELECT COUNT(*) FROM rendez_vous')->fetchOne();
        $totalPages = max(1, (int) ceil($total / self::PER_PAGE));

        if ($page > $totalPages && $total > 0) {
            return $this->redirectToRoute('admin_rdv', ['page' => $totalPages]);
        }

        $offset = ($page - 1) * self::PER_PAGE;
        $limit  = self::PER_PAGE;

        $sql = "SELECT
                    r.id,
                    r.date_heure,
                    r.statut,
                    r.motif,
                    r.mode,
                    e.id as eleve_id,
                    CONCAT(e.prenom, ' ', e.nom) as eleve_nom,
                    c.id as conseiller_id,
                    CONCAT(c.prenom, ' ', c.nom) as conseiller_nom
                FROM rendez_vous r
                LEFT JOIN utilisateur e ON r.eleve_id = e.id
                LEFT JOIN utilisateur c ON r.conseiller_id = c.id
                ORDER BY r.date_heure DESC
                LIMIT {$limit} OFFSET {$offset}";

        $rendezVous = $conn->prepare($sql)->executeQuery()->fetchAllAssociative();

        return $this->render('admin/rendez_vous/index.html.twig', [
            'rendezVous' => $rendezVous,
            'pagination' => [
                'page'       => min($page, $totalPages),
                'perPage'    => self::PER_PAGE,
                'total'      => $total,
                'totalPages' => $totalPages,
            ],
        ]);
    }

    #[Route('/new', name: 'admin_rdv_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $rdv  = new RendezVous();
        $form = $this->createForm(RendezVousType::class, $rdv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($rdv);
            $em->flush();
            $this->addFlash('success', 'Rendez-vous créé avec succès.');
            return $this->redirectToRoute('admin_rdv');
        }

        return $this->render('admin/rendez_vous/new.html.twig', ['form' => $form]);
    }

    #[Route('/{id}', name: 'admin_rdv_show', methods: ['GET'])]
    public function show(RendezVous $rdv): Response
    {
        return $this->render('admin/rendez_vous/show.html.twig', ['rdv' => $rdv]);
    }

    #[Route('/{id}/edit', name: 'admin_rdv_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RendezVous $rdv, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(RendezVousType::class, $rdv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Rendez-vous modifié avec succès.');
            return $this->redirectToRoute('admin_rdv');
        }

        return $this->render('admin/rendez_vous/edit.html.twig', [
            'rdv'  => $rdv,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_rdv_delete', methods: ['POST'])]
    public function delete(Request $request, RendezVous $rdv, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rdv->getId(), $request->getPayload()->getString('_token'))) {
            $em->remove($rdv);
            $em->flush();
            $this->addFlash('success', 'Rendez-vous supprimé.');
        }
        return $this->redirectToRoute('admin_rdv');
    }
}