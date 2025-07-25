# 📗 Créer un service

Afin de créer un service, il faut créer un fichier PHP dans le dossier `src/Service/` sous le format `<Nom>Interface.php`. Ce fichier doit contenir une unique classe PHP, celle du service que vous souhaitez créer, ainsi que l'ensemble des méthodes nécessaires pour répondre à vos besoins.

Une fois votre fichier PHP terminé, il est important de vérifier qu'il n'y est pas d'éventuelles erreurs de syntaxe via la commande ` php -l src/Service/<Nom>Interface.php`.

Symfony détecte automatiquement les services mais il peut être important de vérifier qu'un service est bien pris en compte. Pour cela, il faut exécuter la commande `php bin/console debug:container App\Service\<Nom>Interface` (Il faut indiquer `<namespace><classe>` après `debug:container`, et non le chemin - Ici le namespace est `App\Service` et la classe `<Nom>Interface`).

[DOC - Services Symfony](https://symfony.com/doc/8.0/service_container.html)
[DOC - Debugger un Service Symfony](https://symfony.com/doc/8.0/service_container/debug.html)

Le fichier de configuration est [services.yaml](/config/services.yaml). 

Normalement, il n'est pas vraiment nécessaire d'y toucher puisque le système d'autowiring détecte automatiquement les services pour nous.