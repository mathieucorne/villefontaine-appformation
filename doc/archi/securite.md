# 🔒 Sécurité 

➡️ [Documentation technique](../doc.md)

## Système de hashage 

Le système par défaut de hashage est bcrypt. Les mots de passes sont chiffrés en base de donnée grâce au hash. 

Si le hash correspond alors la connexion est autorisée.

Il est possible d' augmenter le "coût" (cost) du hashage ce qui aura pour résusltat d'améliorer la protection du mot de passe en utilisant plus d'énergie en échange.

## Gérer les rôles

[DOC - Gérer les rôles](https://nouvelle-techno.fr/articles/live-coding-gerer-les-roles-utilisateur-avec-symfony-4#:~:text=Nous%20attribuons%20les%20r%C3%B4les)