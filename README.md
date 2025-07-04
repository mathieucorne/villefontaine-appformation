# AppFormation

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

--- 

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

##### Créer un flux Turbo Stream (WebSocket)

[Turbo](https://ux.symfony.com/turbo)
[DOC - Turbo](https://symfony.com/bundles/ux-turbo/current/index.html)

### API

#### Outlook et Teams
[DOC - Créer un événement Outlook](https://learn.microsoft.com/fr-fr/graph/api/calendar-post-events?view=graph-rest-1.0&tabs=http#response)

[DOC - Créer une réunion](https://learn.microsoft.com/en-us/graph/api/application-post-onlinemeetings?view=graph-rest-1.0&tabs=http)


[DOC - Créer et envoyer un mail](https://learn.microsoft.com/fr-fr/graph/api/user-sendmail?view=graph-rest-1.0&tabs=http)

### FullCalendar

[DOC - Calendrier WebComponent](https://fullcalendar.io/docs/web-component)
[DOC - Calendrier à la semaine](https://fullcalendar.io/docs/business-hours)

---

## Modèle Logique de Données

- `utilisateur` (<u>**id**</u>, prenom, nom, email, password, type, **#id_service**)
- `service` (<u>**id**</u>, nom, email)
- `participation` (<u>**#id_utilisateur, #id_session**</u>, date_inscription, type_inscription)
- `session` (<u>**id**</u>, titre, heure_debut, heure_fin, nb_participants_max, statut_session, **#id_formation**, **#id_salle**)
- `salle` (<u>**id**</u>, nom, batiment, nb_places_max)
- `formation` (<u>**id**</u>, titre, description, imageURL, estVisible)
- `competence` (<u>**id**</u>, nom)
- `utilisateur_competence` (<u>**#id_utilisateur**, **#id_competences**</u>)
- `formation_competence` (<u>**#id_formation, #id_competence**</u>)
- `session_service` (<u>**#id_service, #id_session**</u>)
- `parametre` (<u>**id**</u>, nom, valeur, commentaires)


---

## Résoudre les erreurs

### Erreurs de dépendances (DEP)

#### DEP1

A l'installation du bundle Symfony Maker avec l'aide la commande "composer require --dev symfony/maker-bundle", l'erreur **DEP1** peut survenir, empêchant l'installation de certains éléments.

![Failed to download symfony/x from dist: The zip extension and unzip/7z commands are both missing, skipping.](./doc_AppFormation/erreur_DEP/erreur_DEP1.png "Erreur DEP1")

#### DEP2

Au moment de créer la base de données via Doctrine (php bin/console doctrine:database:create), l'erreur DEP2 peut survenir, empêchant la création par Doctrine de cette même base de données.

Cette erreur est liée à une mauvaise configuration du fichier php.ini, plus précisément le PHP principal renseigné dans le PATH. 

**Pour résoudre l'erreur DEP2**, il faut décommenter les lignes `;extension=pdo_mysql` et `;extension=mysqli` en enlevant `;`.

![Could not create database `app` for connection named default An exception occurred in the driver: could not find driver](./doc_AppFormation/erreur_DEP/erreur_DEP2.png)

#### DEP3

Au moment de l'installation des dépendances Symfony ou d'autres dépendances PHP, en utilisant Composer, l'erreur DEP3 peut survenir, notamment via les commandes suivantes :
```
composer install
composer require x/x (ex: symfony/orm-pack)
```

![The openssl extension is required for SSL/TLS protection but is not available.](./doc_AppFormation/erreur_DEP/erreur_DEP3.png).

Cette erreur est liée à une mauvaise configuration du fichier php.ini, plus précisément le PHP principal renseigné dans le PATH.

**Pour résoudre l'erreur DEP3**, il faut décommenter la ligne `;extension=openssl` en enlevant le `;`.

#### DEP4

Au moment de la migration via Doctrine via la commande **php bin/console doctrine:migration:migrate**, l'erreur DEP4 peut survenir, en raison de la non création au préalable de la base de données renseignée dans le **fichier .env**. 

![An exception occured in the driver: SQLSTATE[YY000] [1049] Unknow database 'app'](./doc_AppFormation/erreur_DEP/erreur_DEP4.png)

> **Exemple de fichier .env**
> 
> ```DATABASE_URL="mysql://root@127.0.0.1:3306/app?serverVersion=10.5.8-MariaDB"```
> 
> La base de donnée renseignée est celle renseignée entre / et le ?, ici **app**. 

**Pour résoudre l'erreur DEP4**, il faut créer au préalable la base de données, ce qui peut se faire également via Doctrine avec la commande :
```php bin/console doctrine:database:create```

#### DEP5

Au moment du chargement d'une page dans le navigateur, l'erreur DEP5 peut survenir, en raison du non-démarrage du serveur MySQL dans XAMPP (souvent par inadvertance).

**Erreur DEP5 dans phpMyAdmin**
![phpMyAdmin - mysql::real_connect(): (HY000/2002): Aucune connexion n'a pu être établie car l'ordinateur cible l'a expressément refusée](./doc_AppFormation/erreur_DEP/erreur_DEP5_phpmyadmin.png)

**Erreur DEP5 dans Symfony**
![Symfony - An exception occured in the driver: SQLSTATE[HY000][2002] Aucune connexion n'a pu être établie car l'ordinateur cible l'a expressément refusée](./doc_AppFormation/erreur_DEP/erreur_DEP5_Symfony.png)

**Pour résoudre l'erreur DEP5**, il faut appuyer sur le bouton `Start` en face de MySQL dans le Control Panel de XAMPP.

### Erreurs concernant les outils de développement (TOOL)

Lors du lancement de phpMyAdmin via XAMPP (localhost), l'erreur TOOL1 peut survenir. 

Contrairement à ce qui est indiqué dans l'erreur, cela n'est pas lié à un problème d'extension, et il est possible que MySQL fonctionne correctement (ainsi que phpMyAdmin) et soit décommenté dans le php.ini, sans que l'erreur disparaisse. 

![Il manque l'extension mysqli](./doc_AppFormation/erreur_TOOL/erreur_TOOL1.png).

Bien que la raison n'a pas été trouvée, il existe un moyen pour contourner cette erreur et accéder à phpMyAdmin.

**Pour contourner l'erreur TOOL1 :**
1. Se rendre dans le dossier où phpMyAdmin est installé, généralement `C:/xampp/phpmyadmin`.

2. Ouvrir un invite de commande dans le dossier (clic droit > "Ouvrir dans le terminal")

3. Lancer un serveur PHP via la commande `php -S localhost:5000`. Le serveur se lancera sur le port 5000.

4. Ouvrir un navigateur et entrez le chemin `localhost:5000`.

#### TOOL2

Au moment de lancer le serveur MySQL dans XAMPP, l'erreur TOOL2 peut survenir et empêcher le démarrage complet de MySQL, en raison de fichiers corrompus dans le dossier `C:\xampp\mysql\data`.

![Logs MySQL - File 'C:\xampp\mysql\data\ibtmp1' size is now 12MB](./doc_AppFormation/erreur_TOOL/erreur_TOOL2.png).

**Pour résoudre l'erreur TOOL2**, il faut copier les fichiers du dossier `C:\xampp\mysql\backup` en remplaçant l'ensemble de ceux du dossier `C:\xampp\mysql\data`.

[Résoudre l'erreur TOOL2](https://stackoverflow.com/questions/56767200/cant-run-xampp-mysql)

#### TOOL3

Au moment de l'utilisation du dossier de backup pour résoudre l'erreur TOOL2, l'erreur TOOL3 peut survenir lorsque l'on essaye de supprimer la base de données afin de la refaire de zéro, en raison de la corruption du dossier de données correspondant à cette même BDD.

![phpMyAdmin - #1010 - Erreur en effançant la base (rmdir '.\app', erreur 41 "Directory not empty)](./doc_AppFormation/erreur_TOOL/erreur_TOOL3.png).

**Attention, la base de données corrompue nécessitant d'être supprimée, il est nécessaire d'exporter les données des tables au préalable, sans quoi toutes les informations présentes seront perdues.**

**Pour résoudre l'erreur TOO3**, il faut supprimer la base de données corrompue. Cependant, phpMyAdmin n'arrive pas forcément à supprimer totalement la base de données, même si d'apparence il n'y a plus aucune table. il faut donc supprimer le dossier de la base de données corrompue directement dans `C:\xampp\mysql\data\`, le dossier à supprimer étant celui du même nom que la base de données dans phpMyAdmin. 

Une fois la base de données supprimée, il faut utiliser les commandes pour créer de nouveau l'architecture de la base de données
- `php bin/console doctrine:database:create` - Créer la base de données renseigné dans le fichier .env comme étant celui de l'application
- `php bin/console make:migration` - (OPTIONNEL si fichier de migration déjà existant) Créer un fichier de migration, qui permet à l'ORM de transposer le schéma d'architecture orienté objet en tables relationnelles
- `php bin/console doctrine:migration:migrate` - Exécuter la migration pour mettre à jour l'architecture de la base de données.


[Résoudre l'erreur TOOL3](https://stackoverflow.com/questions/17947255/error-in-dropping-a-database-in-mysql-cant-rmdir-oro-errno-41)

## Sécurité 

### Système de hashage 

Le système par défaut de hashage est bcrypt. Les mots de passes sont chiffrés en base de donnée grâce au hash. 

Si le hash correspond alors la connexion est autorisée.

Il est possible d' augmenter le "coût" (cost) du hashage ce qui aura pour résusltat d'améliorer la protection du mot de passe en utilisant plus d'énergie en échange. 