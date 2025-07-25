# 📗 Créer une variable globale Twig

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