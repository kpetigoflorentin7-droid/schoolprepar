<?php
namespace App\Controller;

use App\Entity\Filiere;
use App\Form\FiliereType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/filieres')]
#[IsGranted('ROLE_ADMIN')]
class AdminFiliereController extends AbstractController
{
    private const PER_PAGE = 10;

    #[Route('/', name: 'admin_filieres', methods: ['GET'])]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $conn = $em->getConnection();
        $page = max(1, (int) $request->query->get('page', 1));
        $total = (int) $conn->executeQuery('SELECT COUNT(*) FROM filiere')->fetchOne();
        $totalPages = max(1, (int) ceil($total / self::PER_PAGE));

        if ($page > $totalPages && $total > 0) {
            return $this->redirectToRoute('admin_filieres', ['page' => $totalPages]);
        }

        $offset = ($page - 1) * self::PER_PAGE;
        $limit  = self::PER_PAGE;
        $sql    = "SELECT f.*, COUNT(ef.etablissement_id) as nb_etablissements
                   FROM filiere f
                   LEFT JOIN etablissement_filiere ef ON f.id = ef.filiere_id
                   GROUP BY f.id
                   ORDER BY f.nom ASC
                   LIMIT {$limit} OFFSET {$offset}";
        $result = $conn->executeQuery($sql);

        return $this->render('admin/filiere/index.html.twig', [
            'filieres'   => $result->fetchAllAssociative(),
            'pagination' => [
                'page'       => min($page, $totalPages),
                'perPage'    => self::PER_PAGE,
                'total'      => $total,
                'totalPages' => $totalPages,
            ],
        ]);
    }

    #[Route('/new', name: 'admin_filiere_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $filiere = new Filiere();
        $form    = $this->createForm(FiliereType::class, $filiere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($filiere);
            $em->flush();
            $this->addFlash('success', 'Filière créée avec succès.');
            return $this->redirectToRoute('admin_filieres');
        }

        return $this->render('admin/filiere/new.html.twig', ['form' => $form]);
    }

    #[Route('/{id}', name: 'admin_filiere_show', methods: ['GET'])]
    public function show(int $id, EntityManagerInterface $em): Response
    {
        $conn    = $em->getConnection();
        $filiere = $conn->executeQuery('SELECT * FROM filiere WHERE id = :id', ['id' => $id])->fetchAssociative();
        if (!$filiere) {
            throw $this->createNotFoundException('Filière non trouvée');
        }

        $etablissements = $conn->executeQuery(
            'SELECT e.id, e.nom, e.ville FROM etablissement e
             JOIN etablissement_filiere ef ON e.id = ef.etablissement_id
             WHERE ef.filiere_id = :id',
            ['id' => $id]
        )->fetchAllAssociative();

        return $this->render('admin/filiere/show.html.twig', [
            'filiere'        => $filiere,
            'etablissements' => $etablissements,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_filiere_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Filiere $filiere, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(FiliereType::class, $filiere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Filière modifiée avec succès.');
            return $this->redirectToRoute('admin_filieres');
        }

        return $this->render('admin/filiere/edit.html.twig', [
            'filiere' => $filiere,
            'form'    => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_filiere_delete', methods: ['POST'])]
    public function delete(Request $request, Filiere $filiere, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$filiere->getId(), $request->request->get('_token'))) {
            $em->remove($filiere);
            $em->flush();
            $this->addFlash('success', 'Filière supprimée.');
        }
        return $this->redirectToRoute('admin_filieres');
    }
}