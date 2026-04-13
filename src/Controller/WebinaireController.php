<?php
// src/Controller/WebinaireController.php
namespace App\Controller;

use App\Entity\Evenement;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WebinaireController extends AbstractController
{
    #[Route('/webinaires', name: 'app_webinaires')]
    public function index(EntityManagerInterface $em): Response
    {
        $events = $em->getRepository(Evenement::class)->findBy([], ['date' => 'ASC']);

        $webinaires = array_map(static function (Evenement $ev): array {
            return [
                'id' => $ev->getId(),
                'nom' => $ev->getTitre(),
                'domaine' => $ev->getType() ?: 'Webinaire',
                'description' => $ev->getDescription() ?: 'Webinaire à venir.',
                'image' => $ev->getEtablissement()?->getImage(),
            ];
        }, $events);

        return $this->render('front/filiere/index.html.twig', [
            'filieres' => $webinaires,
        ]);
    }

    #[Route('/webinaires/{id}', name: 'app_webinaire_show', requirements: ['id' => '\d+'])]
    public function show(Evenement $webinaire): Response
    {
        $filiereLikeData = [
            'id' => $webinaire->getId(),
            'nom' => $webinaire->getTitre(),
            'domaine' => $webinaire->getType() ?: 'Webinaire',
            'image' => $webinaire->getEtablissement()?->getImage(),
            'description' => $webinaire->getDescription() ?: 'Description à venir.',
            'duree' => 'Session prévue le ' . ($webinaire->getDate()?->format('d/m/Y H:i') ?? '-'),
            'conditionsAdmission' => 'Inscription gratuite sur la plateforme.',
            'debouches' => [],
        ];

        return $this->render('front/filiere/show.html.twig', [
            'filiere' => $filiereLikeData,
        ]);
    }
}
