<?php
namespace App\Controller;

use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/utilisateurs')]
#[IsGranted('ROLE_ADMIN')]
class AdminUtilisateurController extends AbstractController
{
    private const PER_PAGE = 9;

    #[Route('/', name: 'admin_utilisateurs', methods: ['GET'])]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $conn       = $em->getConnection();
        $page       = max(1, (int) $request->query->get('page', 1));
        $total      = (int) $conn->executeQuery('SELECT COUNT(*) FROM utilisateur')->fetchOne();
        $totalPages = max(1, (int) ceil($total / self::PER_PAGE));

        if ($page > $totalPages && $total > 0) {
            return $this->redirectToRoute('admin_utilisateurs', ['page' => $totalPages]);
        }

        $offset = ($page - 1) * self::PER_PAGE;
        $limit  = self::PER_PAGE;
        $sql    = "SELECT id, nom, prenom, email, telephone, roles
                   FROM utilisateur
                   ORDER BY nom ASC
                   LIMIT {$limit} OFFSET {$offset}";
        $result = $conn->executeQuery($sql);

        return $this->render('admin/utilisateur/index.html.twig', [
            'utilisateurs' => $result->fetchAllAssociative(),
            'pagination'   => [
                'page'       => min($page, $totalPages),
                'perPage'    => self::PER_PAGE,
                'total'      => $total,
                'totalPages' => $totalPages,
            ],
        ]);
    }

    #[Route('/{id}', name: 'admin_utilisateur_show', methods: ['GET'])]
    public function show(int $id, EntityManagerInterface $em): Response
    {
        $conn        = $em->getConnection();
        $utilisateur = $conn->executeQuery(
            'SELECT id, nom, prenom, email, telephone, roles FROM utilisateur WHERE id = :id',
            ['id' => $id]
        )->fetchAssociative();

        if (!$utilisateur) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }

        return $this->render('admin/utilisateur/show.html.twig', [
            'utilisateur' => $utilisateur,
        ]);
    }

    #[Route('/{id}', name: 'admin_utilisateur_delete', methods: ['POST'])]
    public function delete(Request $request, Utilisateur $u, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$u->getId(), $request->request->get('_token'))) {
            $em->remove($u);
            $em->flush();
            $this->addFlash('success', 'Utilisateur supprimé.');
        }
        return $this->redirectToRoute('admin_utilisateurs');
    }
}