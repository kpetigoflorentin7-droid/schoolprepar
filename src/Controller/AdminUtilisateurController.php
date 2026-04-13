<?php
namespace App\Controller;

use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/utilisateurs')]
class AdminUtilisateurController extends AbstractController
{
    #[Route('/', name: 'admin_utilisateurs', methods: ['GET'])]
    public function index(EntityManagerInterface $em): Response
    {
        $conn = $em->getConnection();
        $sql = "SELECT id, nom, prenom, email, telephone, roles FROM utilisateur ORDER BY nom ASC";
        $result = $conn->executeQuery($sql);
        
        return $this->render('admin/utilisateur/index.html.twig', [
            'utilisateurs' => $result->fetchAllAssociative(),
        ]);
    }

    #[Route('/{id}', name: 'admin_utilisateur_show', methods: ['GET'])]
    public function show(int $id, EntityManagerInterface $em): Response
    {
        $conn = $em->getConnection();
        $sql = "SELECT id, nom, prenom, email, telephone, roles FROM utilisateur WHERE id = :id";
        $utilisateur = $conn->executeQuery($sql, ['id' => $id])->fetchAssociative();
        
        if (!$utilisateur) throw $this->createNotFoundException('Utilisateur non trouvé');
        
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