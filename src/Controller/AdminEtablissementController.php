<?php
namespace App\Controller;

use App\Entity\Etablissement;
use App\Form\EtablissementType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/etablissements')]
#[IsGranted('ROLE_ADMIN')]
class AdminEtablissementController extends AbstractController
{
    private const PER_PAGE = 10;

    #[Route('/', name: 'admin_etablissements', methods: ['GET'])]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $conn = $em->getConnection();
        $page = max(1, (int) $request->query->get('page', 1));
        $total = (int) $conn->executeQuery('SELECT COUNT(*) FROM etablissement')->fetchOne();
        $totalPages = max(1, (int) ceil($total / self::PER_PAGE));

        if ($page > $totalPages && $total > 0) {
            return $this->redirectToRoute('admin_etablissements', ['page' => $totalPages]);
        }

        $offset = ($page - 1) * self::PER_PAGE;
        $limit  = self::PER_PAGE;
        $sql    = "SELECT e.*, COUNT(ef.filiere_id) as nb_filieres
                   FROM etablissement e
                   LEFT JOIN etablissement_filiere ef ON e.id = ef.etablissement_id
                   GROUP BY e.id
                   ORDER BY e.nom ASC
                   LIMIT {$limit} OFFSET {$offset}";
        $result = $conn->executeQuery($sql);

        return $this->render('admin/etablissement/index.html.twig', [
            'etablissements' => $result->fetchAllAssociative(),
            'pagination'     => [
                'page'       => min($page, $totalPages),
                'perPage'    => self::PER_PAGE,
                'total'      => $total,
                'totalPages' => $totalPages,
            ],
        ]);
    }

    #[Route('/new', name: 'admin_etablissement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $etab = new Etablissement();
        $form = $this->createForm(EtablissementType::class, $etab);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($etab);
            $em->flush();
            $this->addFlash('success', 'Établissement créé avec succès.');
            return $this->redirectToRoute('admin_etablissements');
        }

        return $this->render('admin/etablissement/new.html.twig', ['form' => $form]);
    }

    #[Route('/{id}', name: 'admin_etablissement_show', methods: ['GET'])]
    public function show(int $id, EntityManagerInterface $em): Response
    {
        $conn          = $em->getConnection();
        $etablissement = $conn->executeQuery('SELECT * FROM etablissement WHERE id = :id', ['id' => $id])->fetchAssociative();
        if (!$etablissement) {
            throw $this->createNotFoundException('Établissement non trouvé');
        }

        $filieres = $conn->executeQuery(
            'SELECT f.id, f.nom, f.domaine FROM filiere f
             JOIN etablissement_filiere ef ON f.id = ef.filiere_id
             WHERE ef.etablissement_id = :id',
            ['id' => $id]
        )->fetchAllAssociative();

        return $this->render('admin/etablissement/show.html.twig', [
            'etablissement' => $etablissement,
            'filieres'      => $filieres,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_etablissement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Etablissement $etab, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(EtablissementType::class, $etab);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Établissement modifié avec succès.');
            return $this->redirectToRoute('admin_etablissements');
        }

        return $this->render('admin/etablissement/edit.html.twig', [
            'etablissement' => $etab,
            'form'          => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_etablissement_delete', methods: ['POST'])]
    public function delete(Request $request, Etablissement $etab, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$etab->getId(), $request->request->get('_token'))) {
            $em->remove($etab);
            $em->flush();
            $this->addFlash('success', 'Établissement supprimé.');
        }
        return $this->redirectToRoute('admin_etablissements');
    }
}