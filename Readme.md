# SchoolPrepar – TP2 Symfony
# KPETIGO Florentin – GL – UE IT 232 – 2025/2026

## STRUCTURE LIVRÉE
```
templates/
├── front/
│   ├── base.html.twig          ← layout principal front
│   ├── home.html.twig          ← page d'accueil (index.html converti)
│   ├── partials/
│   │   ├── subheader.html.twig
│   │   ├── nav.html.twig
│   │   └── footer.html.twig
│   ├── filiere/
│   │   ├── index.html.twig     ← liste filières (webinaires.html converti)
│   │   └── show.html.twig      ← détail filière (webinaire-detail.html converti)
│   └── etablissement/
│       └── index.html.twig
└── admin/
    ├── base.html.twig          ← layout admin (AdminLTE)
    ├── dashboard.html.twig     ← tableau de bord (admin.html converti)
    ├── partials/
    │   ├── nav.html.twig
    │   ├── aside.html.twig     ← sidebar
    │   └── footer.html.twig
    ├── filiere/
    │   └── index.html.twig
    ├── etablissement/
    │   └── index.html.twig
    └── utilisateur/
        └── index.html.twig     ← CRUD users (admin-utilisateurs.html converti)

src/Controller/
├── HomeController.php              → route /
├── FiliereController.php           → routes /filieres  /filieres/{id}
├── EtablissementController.php     → route /etablissements
├── WebinaireController.php         → routes /webinaires  /webinaires/{id}
├── AdminDashboardController.php    → route /admin
├── AdminFiliereController.php      → route /admin/filieres
├── AdminEtablissementController.php→ route /admin/etablissements
└── AdminUtilisateurController.php  → route /admin/utilisateurs
```

## ÉTAPE 1 — Copier les contrôleurs dans le projet
Copie tous les fichiers de src/Controller/ dans ton projet :
→ SchoolPrepar/src/Controller/

## ÉTAPE 2 — Copier les templates dans le projet
Copie tout le dossier templates/ dans ton projet :
→ SchoolPrepar/templates/
(Supprime les anciens dossiers home/ et course/ si tu veux repartir propre)

## ÉTAPE 3 — Copier les assets CSS/JS dans public/
Depuis le template HTML téléchargé (edu-meeting), copie :
  vendor/  → SchoolPrepar/public/front/vendor/
  assets/  → SchoolPrepar/public/front/assets/

Depuis AdminLTE téléchargé (adminlte.io), copie :
  plugins/ → SchoolPrepar/public/admin/plugins/
  dist/    → SchoolPrepar/public/admin/dist/

Le fichier schoolprepar.css → SchoolPrepar/public/front/assets/css/schoolprepar.css
                            → SchoolPrepar/public/admin/assets/css/schoolprepar.css

## ÉTAPE 4 — Lancer le serveur
  cd SchoolPrepar
  symfony server:start

## ÉTAPE 5 — Tester les URLs
  http://localhost:8000/              → Accueil
  http://localhost:8000/filieres      → Liste filières
  http://localhost:8000/filieres/1    → Détail filière
  http://localhost:8000/etablissements→ Établissements
  http://localhost:8000/webinaires    → Webinaires
  http://localhost:8000/admin         → Dashboard admin
  http://localhost:8000/admin/filieres         → Admin filières
  http://localhost:8000/admin/etablissements   → Admin établissements
  http://localhost:8000/admin/utilisateurs     → Admin utilisateurs (avec modals)

