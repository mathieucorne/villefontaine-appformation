# 🔐 Sécurité 

➡️ [Documentation technique](../doc.md)

Ce document explique comment la sécurité est implémentée dans l'application Symfony : authentification, rôles, contrôle d'accès, hashage, CSRF, etc.

## 🔑 Authentification

L'application utilise le **formulaire de connexion Symfony** pour l'authentification (`app_login`).

## 🧂 Hashage des mots de passe

Le hashage est automatique avec Symfony via password_hashers. L'algorithme par défaut (auto) sélectionne le plus sécurisé disponible sur le système (actuellement bcrypt). 

A chaque tentative de connexion, le mot de passe saisi est hashé et comparé au hash du mot de passe déjà présent en base de données. Si le hash correspond alors la connexion est autorisée.

Il est possible d' augmenter le "coût" (cost) du hashage ce qui aura pour résultat d'améliorer la protection du mot de passe en utilisant plus d'énergie en échange.

## 🛡️ CSRF (Cross-Site Request Forgery)

Les formulaires Symfony intègrent automatiquement une protection CSRF via un champ _token caché

```html
<form method="post">
    <input type="hidden" name="_token" value="{{ crsf_token('delete' ~ session.id) }}">
    <button>Supprimer</button>
</form>
```

## 🔏 Sécurité des routes

Les droits sont définis dans `security.yaml` à la section `access_control`, mais peuvent aussi être contrôlés dans les contrôleurs (fine-grain access).

- `/login` : accessible à tous (PUBLIC_ACCESS)
- `/*`, role : accessible à un utilisateur connecté (ROLE_USER)
- `/admin/*` : accessible à un gestionnaire de formations (ROLE_RH)
- `/admin/(utilisateur/salle/service)` : accessible uniquement à un administrateur (ROLE_ADMIN)

## 🧭 Bonnes pratiques

- Ne jamais versionner `.env` (contient des secrets)
- Toujours encoder les mots de passe via `PasswordHasherInterface`
- Utiliser `https` en production
- Ne jamais afficher d'erreur technique en production (APP_DEBUG=false)
- Limiter les tentatives de login si nécessaire (RateLimiter)

[Documentation Symfony - SecurityBundle](https://symfony.com/doc/current/security.html)