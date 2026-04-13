<?php
// src/Controller/HomeController.php
namespace App\Controller;

use App\Entity\Evenement;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $em): Response
    {
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
                'id' => $ev->getId(),
                'titre' => $ev->getTitre(),
                'domaine' => $ev->getType() ?: 'Webinaire',
                'mois' => $ev->getDate()?->format('M') ?? '-',
                'jour' => $ev->getDate()?->format('d') ?? '-',
                'image' => $ev->getEtablissement()?->getImage(),
                'description' => $ev->getDescription() ?: 'Webinaire à venir.',
            ];
        }, $events);

        return $this->render('front/home.html.twig', [
            'stats' => [
                'filieres'       => '1 200',
                'etablissements' => '350',
                'conseillers'    => '80',
                'eleves'         => '4 500',
            ],
            'webinaires' => $webinaires,
            'filieres_vedettes' => [
                ['nom'=>'Génie Logiciel','image'=>'course-01.jpg','etoiles'=>4,'niveau'=>'Bac+3'],
                ['nom'=>'BTS Comptabilité & Gestion','image'=>'course-02.jpg','etoiles'=>4,'niveau'=>'Bac+2'],
                ['nom'=>'Licence Droit des Affaires','image'=>'course-03.jpg','etoiles'=>5,'niveau'=>'Bac+3'],
                ['nom'=>'Master Génie Civil','image'=>'course-04.jpg','etoiles'=>4,'niveau'=>'Bac+5'],
                ['nom'=>'Études de Médecine','image'=>'course-01.jpg','etoiles'=>5,'niveau'=>'Bac+7'],
            ],
        ]);
    }
}
