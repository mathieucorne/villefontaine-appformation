# 🧩 AppFormation

Une application Symfony pour gérer et réserver des sessions de formation

---

## ⚙️ Prérequis

Avant de lancer le projet en local, tu dois avoir installé : 

- [VS Code](https://code.visualstudio.com/download)
- [PHP >= 8.2](https://windows.php.net/download/), **PHP doit être ajouté aux variables d'environement.**
- [Composer](https://getcomposer.org/download/)
- [XAMPP](https://sourceforge.net/projects/xampp/)

---

## 🚀 Installation rapide

```bash
git clone https://github.com/mathieucorne/villefontaine-appformation.git
cd villefontaine-appformation
composer install
```

**Configurer la base données**
```bash
# Modifier DATABASE_URL dans .env si besoin
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

**Lancer le serveur local**
```bash
symfony server:start
```

Accéder à l'application :
http://localhost:8000

## 📕 Documentation technique
➡️ [Voir la documentation technique complète](./doc/doc.md)