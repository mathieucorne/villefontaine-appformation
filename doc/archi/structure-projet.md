# 🗃️ Structure du projet

➡️ [Documentation technique](../doc.md)

Ce fichier décrit l'organisation des fichiers et dossiers dans l'application Symfony

- `/config` : Configuration des bundles, routes, services...
- `/doc` : Documentation
- `/migrations` : Migrations Doctrine
- `/public` : Front public (index.php, assets compilés)
- `/tests` : Tests PHPUnit
- `/src`
    - `/Controller` : Controlleurs HTTP
    - `/Entity` : Entités Doctrine
    - `/EventSubscriber` : Écouteurs d'événements qui suit le [Design Pattern Observer](https://refactoring.guru/fr/design-patterns/observer)
    - `/Form : Formulaires` personnalisés
    - `/Service` : Services (instanciés automatiquement grâce à l'autowiring)
    - `/Repository` : Requêtes personnalisées
- `/templates` : Vues Twig