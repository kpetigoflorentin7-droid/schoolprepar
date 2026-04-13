<?php
// src/Controller/AdminDashboardController.php
namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Filiere;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminDashboardController extends AbstractController
{
    #[Route('/admin', name: 'admin_dashboard')]
    public function index(EntityManagerInterface $em): Response
    {
        $stats = [
            'filieres'       => (int) $em->getRepository(Filiere::class)->count([]),
            'etablissements' => (int) $em->getRepository('App\Entity\Etablissement')->count([]),
            'utilisateurs'   => (int) $em->getRepository(Utilisateur::class)->count([]),
            'conseillers'    => (int) $em->createQueryBuilder()
                ->select('COUNT(u.id)')
                ->from(Utilisateur::class, 'u')
                ->where('u.roles LIKE :role')
                ->setParameter('role', '%ROLE_CONSEILLER%')
                ->getQuery()
                ->getSingleScalarResult(),
        ];

        $utilisateursRecentsEntities = $em->getRepository(Utilisateur::class)->findBy([], ['id' => 'DESC'], 5);
        $utilisateursRecents = array_map(static function (Utilisateur $u): array {
            $roles = $u->getRoles();
            $role = in_array('ROLE_ADMIN', $roles, true)
                ? 'admin'
                : (in_array('ROLE_CONSEILLER', $roles, true) ? 'conseiller' : 'eleve');

            return [
                'id' => $u->getId(),
                'nom' => $u->getNomComplet(),
                'email' => $u->getEmail(),
                'role' => $role,
                'statut' => 'active',
            ];
        }, $utilisateursRecentsEntities);

        $filieresPopulaires = $em->createQueryBuilder()
            ->select('f.nom AS nom, f.domaine AS domaine, COUNT(e.id) AS nb_etablissements')
            ->from(Filiere::class, 'f')
            ->leftJoin('f.etablissements', 'e')
            ->groupBy('f.id')
            ->orderBy('nb_etablissements', 'DESC')
            ->addOrderBy('f.nom', 'ASC')
            ->setMaxResults(4)
            ->getQuery()
            ->getArrayResult();

        $webinairesProchainsEntities = $em->createQueryBuilder()
            ->select('ev')
            ->from(Evenement::class, 'ev')
            ->where('ev.date >= :now')
            ->setParameter('now', new \DateTimeImmutable())
            ->orderBy('ev.date', 'ASC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();

        $webinairesProchains = array_map(static function (Evenement $ev): array {
            return [
                'titre' => $ev->getTitre(),
                'date' => $ev->getDate()?->format('d/m/Y H:i') ?? '-',
                'image' => $ev->getEtablissement()?->getImage(),
            ];
        }, $webinairesProchainsEntities);

        return $this->render('admin/dashboard.html.twig', [
            'stats' => $stats,
            'utilisateurs_recents' => $utilisateursRecents,
            'filieres_populaires' => $filieresPopulaires,
            'webinaires_prochains' => $webinairesProchains,
        ]);
    }
}
