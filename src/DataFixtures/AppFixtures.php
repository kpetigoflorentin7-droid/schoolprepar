<?php
namespace App\DataFixtures;

use App\Entity\Debouche;
use App\Entity\Etablissement;
use App\Entity\Evenement;
use App\Entity\Filiere;
use App\Entity\RendezVous;
use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher) {}

    public function load(ObjectManager $em): void
    {
        // ── Filières ──────────────────────────────────────────
        $filieres = [];
        foreach ([
            ['Génie Logiciel',          'Informatique', 'Formation en ingénierie logicielle et développement', 'Bac+3 minimum', 3, 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1000&q=80'],
            ['Web & Internet Management','Informatique', 'Conception et développement web & mobile',            'Bac minimum',   3, 'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?auto=format&fit=crop&w=1000&q=80'],
            ['Réseaux & Télécoms',       'Informatique', 'Administration systèmes, réseaux et sécurité',        'Bac scientifique', 3, 'https://images.unsplash.com/photo-1563986768609-322da13575f3?auto=format&fit=crop&w=1000&q=80'],
            ['Médecine Générale',         'Santé',        'Formation médicale complète (DFGSM + DFASM)',          'Bac D avec mention', 7, 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&w=1000&q=80'],
            ['Droit des Affaires',        'Droit',        'Droit commercial, des entreprises et des contrats',   'Bac minimum',   5, 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&w=1000&q=80'],
        ] as [$nom, $domaine, $desc, $cond, $duree, $image]) {
            $f = (new Filiere())
                ->setNom($nom)->setDomaine($domaine)
                ->setDescription($desc)->setConditionsAdmission($cond)->setDuree($duree)
                ->setImage($image);
            $em->persist($f);
            $filieres[] = $f;
        }

        // ── Établissements + liaison N:N ───────────────────────
        $etabs = [];
        foreach ([
            ['Université de Lomé',   'BP 1515 Lomé',       'Lomé',  'info@ul.tg',          '+228 22 25 50 80', [0,1,2], 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&w=1000&q=80'],
            ['IPNET Institute',       'Rue des Écoles',      'Lomé',  'info@ipnet.tg',        '+228 90 00 00 01', [0,1], 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=1000&q=80'],
            ['Université de Kara',   'BP 43 Kara',          'Kara',  'contact@ukara.tg',    '+228 26 60 60 60', [2,4], 'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=1000&q=80'],
            ['ESTIM Lomé',            'Av. Duisbourg, Lomé', 'Lomé',  'contact@estim.tg',    null,               [1,2], 'https://images.unsplash.com/photo-1498243691581-b145c3f54a5a?auto=format&fit=crop&w=1000&q=80'],
            ['Université de Tokoin', 'Av. Tokoin, Lomé',   'Lomé',  'info@utokoin.tg',      null,               [3,4], 'https://images.unsplash.com/photo-1488190211105-8b0e65b80b4e?auto=format&fit=crop&w=1000&q=80'],
        ] as [$nom, $adr, $ville, $email, $tel, $fIds, $image]) {
            $etab = (new Etablissement())
                ->setNom($nom)->setAdresse($adr)->setVille($ville)
                ->setEmail($email)->setTelephone($tel)
                ->setImage($image);
            foreach ($fIds as $fi) { $etab->addFiliere($filieres[$fi]); }
            $em->persist($etab);
            $etabs[] = $etab;
        }

        // ── Débouchés ─────────────────────────────────────────
        foreach ([
            ['Développeur Full-Stack',  'Informatique', 450000, $filieres[0]],
            ['Chef de projet IT',        'Management',   600000, $filieres[0]],
            ['Développeur Web',          'Numérique',    400000, $filieres[1]],
            ['Admin Réseau',             'Télécoms',     420000, $filieres[2]],
            ['Médecin généraliste',      'Santé',        800000, $filieres[3]],
            ['Juriste d\'entreprise',    'Droit',        550000, $filieres[4]],
        ] as [$metier, $secteur, $salaire, $filiere]) {
            $em->persist((new Debouche())->setMetier($metier)->setSecteur($secteur)
                ->setSalaireMoyen($salaire)->setFiliere($filiere));
        }

        // ── Utilisateurs ──────────────────────────────────────
        $users = [];
        foreach ([
            ['Admin',   'Super',   'admin@schoolprepar.tg',     ['ROLE_ADMIN']],
            ['Kofi',    'Ama',     'ama.kofi@email.com',        ['ROLE_USER']],
            ['Agbeko',  'Komi',    'komi.agbeko@email.com',     ['ROLE_USER']],
            ['Tsevi',   'Elom',    'elom.tsevi@email.com',      ['ROLE_USER']],
            ['Mensah',  'Dzidzor', 'dzidzor.mensah@email.com',  ['ROLE_CONSEILLER']],
            ['Dossou',  'Yawa',    'yawa.dossou@email.com',     ['ROLE_CONSEILLER']],
        ] as [$nom, $prenom, $email, $roles]) {
            $u = (new Utilisateur())->setNom($nom)->setPrenom($prenom)->setEmail($email)->setRoles($roles);
            $u->setPassword($this->hasher->hashPassword($u, 'password123'));
            $em->persist($u);
            $users[] = $u;
        }

        // ── Rendez-vous ───────────────────────────────────────
        foreach ([
            [$users[1], $users[4], '+3 days',  'presentiel', 'confirme',   'Orientation filière Génie Logiciel'],
            [$users[2], $users[4], '+7 days',  'visio',      'en_attente', 'Choix post-bac'],
            [$users[3], $users[5], '+5 days',  'telephone',  'confirme',   'Débouchés en informatique'],
            [$users[1], $users[5], '-2 days',  'visio',      'annule',     'RDV annulé par l\'élève'],
            [$users[2], $users[4], '+14 days', 'presentiel', 'en_attente', 'Suivi parcours orientation'],
        ] as [$eleve, $conseil, $delay, $mode, $statut, $motif]) {
            $rdv = (new RendezVous())->setEleve($eleve)->setConseiller($conseil)
                ->setDateHeure(new \DateTime($delay))
                ->setMode($mode)->setStatut($statut)->setMotif($motif);
            $em->persist($rdv);
        }

        // ── Événements ────────────────────────────────────────
        foreach ([
            ['Journée Portes Ouvertes 2026', 'Visite des campus, rencontres enseignants', '+10 days', 'Campus UL, Lomé',   'conference', 200, $etabs[0]],
            ['Hackathon SchoolPrepar',        'Compétition de programmation 24h',          '+20 days', 'IPNET Institute',   'atelier',     50, $etabs[1]],
            ['Conférence IA & Emploi',        'Tendances IA et marché du travail togo',    '+5 days',  'Amphi A, UL',       'webinaire',  100, $etabs[0]],
            ['Forum Orientation Kara',        'Rencontres élèves-conseillers au nord',     '+30 days', 'Université de Kara','conference', 150, $etabs[2]],
            ['Webinaire Cybersécurité',       'Introduction à la sécurité des systèmes',   '+15 days', 'En ligne (Zoom)',   'webinaire',  300, $etabs[1]],
        ] as [$titre, $desc, $delay, $lieu, $type, $places, $etab]) {
            $ev = (new Evenement())->setTitre($titre)->setDescription($desc)
                ->setDate(new \DateTime($delay))->setLieu($lieu)
                ->setType($type)->setPlacesMax($places)->setEtablissement($etab);
            $em->persist($ev);
        }

        $em->flush();
    }
}