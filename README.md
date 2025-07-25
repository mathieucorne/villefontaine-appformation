# AppFormation

- [Documentation Technique](./doc/README.md)


## Informations sur le projet

- nom : AppFormation - Mairie de Villefontaine
- description : Application interne de réservation de sessions de formations

## Prérequis
- VS Code
- PHP
- Composer
- Node
- npm (Node Package Manager)
- XAMPP

## Initialiser le projet

### Mise en place de l'environnement

#### Outils de développement

> **PHP**
> [Télécharger PHP via le site officiel PHP](https://windows.php.net/download/).
> 
> **PHP doit être ajouté aux variables d'environement.**

> **Composer** 
> [Télécharger Composer via le site officiel Composer](https://getcomposer.org/download/)

> **Symfony**
> [Télécharger Symfony via le site officiel Symfony](https://symfony.com/doc/current/setup.html)

> **XAMPP**
> [Télécharger XAMPP via Sourceforge](https://sourceforge.net/projects/xampp/)

#### Installation des dépendances

>- **ORM Symfony**
>Un ORM (Object Relational Mapper) permet de transposer une architecture orienté objet à une base de données relationnelle comme MySQL ou PostgreSQL, ce qui facilite la maintenance d'une application.
>
>Pour installer l'ORM Symfony :
>`composer require symfony/orm-pack`

> - **Symfony Maker**
> Le bundle Symfony Maker permet de générer des entités ainsi que leurs controlleurs en nous évitant de devoir nous-même écrire le code en utilisant des commandes qui nous guident étape par étape pour le faire.
> 
> Pour installer Symfony Maker :
> `composer require --dev symfony/maker-bundle`

#### Utilisation du Symfony Maker pour modifier l'architecture de la base de données
Symfony suit une architecture **MVC (Model, View, Controller)**, dans la logique d'une **programmation orientée objet (POO)**. Le bundle **Symfony Maker** permet ainsi de créer de manière guidée pour nous les **entités (ou modèles)** ainsi que les **controlleurs**, uniquement via des commandes sans avoir à écrire du code.

**Le bundle Symfony Maker doit être installé au préalable.**

##### Créer une entité
Une entité ou le modèle représente le concept de la donnée à manipuler (Un utilisateur, une formation, une session).
Afin de créer une entité, il faut utiliser la commande :
**php bin/console make:entity**

[DOC - Créer une entité](https://symfony.com/doc/current/the-fast-track/en/8-doctrine.html#creating-entity-classes)

##### Créer un controlleur
Un controlleur représente la classe chargée de manipuler la donnée en elle même pour les opérations de création, lecture, modification et suppression (CRUD).
**php bin/console make:entity**

[DOC - Créer un controller](https://symfony.com/doc/current/controller.html#a-basic-controller)

### Actions Symfony

#### Gérer les rôles

[DOC - Gérer les rôles](https://nouvelle-techno.fr/articles/live-coding-gerer-les-roles-utilisateur-avec-symfony-4#:~:text=Nous%20attribuons%20les%20r%C3%B4les)

#### Créer un service

Afin de créer un service, il faut créer un fichier PHP dans le dossier `src/Service/` sous le format `<Nom>Interface.php`. Ce fichier doit contenir une unique classe PHP, celle du service que vous souhaitez créer, ainsi que l'ensemble des méthodes nécessaires pour répondre à vos besoins.

Une fois votre fichier PHP terminé, il est important de vérifier qu'il n'y est pas d'éventuelles erreurs de syntaxe via la commande ` php -l src/Service/<Nom>Interface.php`.

Symfony détecte automatiquement les services mais il peut être important de vérifier qu'un service est bien pris en compte. Pour cela, il faut exécuter la commande `php bin/console debug:container App\Service\<Nom>Interface` (Il faut indiquer `<namespace><classe>` après `debug:container`, et non le chemin - Ici le namespace est `App\Service` et la classe `<Nom>Interface`).

[DOC - Services Symfony](https://symfony.com/doc/8.0/service_container.html)
[DOC - Debugger un Service Symfony](https://symfony.com/doc/8.0/service_container/debug.html)

Le fichier de configuration est [services.yaml](/config/services.yaml). 

Normalement, il n'est pas vraiment nécessaire d'y toucher puisque le système d'autowiring détecte automatiquement les services pour nous.

##### Créer une variable globale Twig (éventuellement dynamique)

Afin de créer une variable globale Twig qui sera disponible dans tous les templates Twig du projet, il faut ajouter une ligne dans la section `twig > globals` du fichier [twig.yaml](config/packages/twig.yaml):
```
twig:
    file_name_pattern: '*.twig'
    globals:
        <ici>
```

Les variables peuvent être de n'importe quel type primitif, ou être dynamique via l'utilisation d'un Service. Cela permet ainsi de lier des variables à un mécanisme en back-end, qui peut être un appel à une API ou à la BDD directement.

Pour assigner un service à une variable globale Twig, il faut préfixer par `@` comme suit `@<Namespace><Classe>`, sinon le service sera considéré comme une chaîne de caractères :
```
twig:
    file_name_pattern: '*.twig'
    globals:
        parametres: '@App\Service\ParametreInterface'
```

### Créer un flux Turbo Stream (WebSocket)

[Turbo](https://ux.symfony.com/turbo)
[DOC - Turbo](https://symfony.com/bundles/ux-turbo/current/index.html)

### API

#### Symfony avec API Platform
Pour configurer l'API pour les entités, il suffit d'annoter la classe (au dessus) de `#[ApiResource]`.

A partir de là, si cette annotation est ajoutée pour chaque entité, elles seront toutes disponibles à l'adresse `/api`, la page de test API Platform.

Cependant, il est possible de remarquer que certains attributs sont en doublon, comme "nb_places_max", et cela est normal, alors qu'en base de données, il n'y a qu'un seul attribut "nb_places_max"

En fait, Doctrine détecte non seulement la variable PHP qui est "nb_places_max" (si en snake_case) que les getters/setters, qui eux sont en camelCase étant donné qu'ils représentent des noms de méthodes, ce qui fait que l'API renverra à la fois "nb_places_max" et "nbPlacesMax", avec les mêmes valeurs. 

Pour régler cette erreur, il faut modifier la variable PHP en la passant en camelCase mais l'annotant de `#[ORM\Column(name: "nb_places_max"]` pour que la sérialisation se fasse. Ainsi, aucune migration n'est nécessaire. Les requêtes seront automatiquement faîtes avec "nb_places_max" avec la variable PHP `nbPlacesMax` qui respectent la convention en camelCase.

Enfin, ils restent à régler quels sont les attributs renvoyées en lecture et quels sont ceux nécessaires en écriture.

Pour cela, il faut utiliser les Groupes en modifiant l'annotation `#[ApiResource]` en :
```
#[ApiResource(
    normalizationContext: ['groups' => ['session:read']],
    denormalizationContext: ['groups' => ['session:write']]
)]
```
Il suffit d'annoter les variables en fonction de ce que l'on souhaite rendre disponible en lecture et en écriture. Les ID auto-générés et les attributs de relations OneToMany (les tableaux) doivent être accessibles en lecture seulement. En revanche, les autres attributs, y compris les attributs ManyToOne, doivent être accessibles à la fois en lecture et écriture : 
```
    #[Groups(['session:read'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['session:read', 'session:write'])]
    #[ORM\Column(length: 255)]
    private ?string $nom = null;
```

[DOC - Configuration de l'API pour les entités](https://symfony.com/doc/current/the-fast-track/fr/26-api.html)

#### Outlook et Teams
[DOC - Créer un événement Outlook](https://learn.microsoft.com/fr-fr/graph/api/calendar-post-events?view=graph-rest-1.0&tabs=http#response)

[DOC - Créer une réunion](https://learn.microsoft.com/en-us/graph/api/application-post-onlinemeetings?view=graph-rest-1.0&tabs=http)

[DOC - Créer et envoyer un mail](https://learn.microsoft.com/fr-fr/graph/api/user-sendmail?view=graph-rest-1.0&tabs=http)

### FullCalendar

[CalendarBundle](https://github.com/tattali/CalendarBundle?tab=readme-ov-file#1-download-calendarbundle-using-composer)
[DOC - FullCalendar](https://fullcalendar.io/docs/)

### EasyAdmin
[DOC - Créer un backOffice avec EasyAdmin](https://www.youtube.com/watch?v=0zLZ_LnS1Lg)


---

## Sécurité 

### Système de hashage 

Le système par défaut de hashage est bcrypt. Les mots de passes sont chiffrés en base de donnée grâce au hash. 

Si le hash correspond alors la connexion est autorisée.

Il est possible d' augmenter le "coût" (cost) du hashage ce qui aura pour résusltat d'améliorer la protection du mot de passe en utilisant plus d'énergie en échange. 