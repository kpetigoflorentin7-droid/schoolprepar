<?php
// src/Controller/HomeController.php
namespace App\Controller;

use App\Entity\Evenement;
use App\Repository\FiliereRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $em, FiliereRepository $filiereRepository): Response
    {
        // Événements à venir (max 4)
        $events = $em->createQueryBuilder()
            ->select('ev')
            ->from(Evenement::class, 'ev')
            ->where('ev.date >= :now')
            ->setParameter('now', new \DateTimeImmutable())
            ->orderBy('ev.date', 'ASC')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();

        $webinaires = array_map(static function (Evenement $ev): array {
            return [
                'id'          => $ev->getId(),
                'titre'       => $ev->getTitre(),
                'domaine'     => $ev->getType() ?: 'Webinaire',
                'mois'        => $ev->getDate()?->format('M') ?? '-',
                'jour'        => $ev->getDate()?->format('d') ?? '-',
                'image'       => $ev->getEtablissement()?->getImage(),
                'description' => $ev->getDescription() ?: 'Webinaire à venir.',
            ];
        }, $events);

        // Filières populaires depuis la BDD (les 5 avec le plus d'établissements)
        $filieresVedettes = $filiereRepository->findFilieresPopulaires(5);

        return $this->render('front/home.html.twig', [
            'stats' => [
                'filieres'       => '1 200',
                'etablissements' => '350',
                'conseillers'    => '80',
                'eleves'         => '4 500',
            ],
            'webinaires'        => $webinaires,
            'filieres_vedettes' => $filieresVedettes,
        ]);
    }
}