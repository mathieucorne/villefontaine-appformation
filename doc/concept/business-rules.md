# 📘 Règles métiers

Ce document décrit les règles fonctionnelles et métiers qui régissent l'application

➡️ [Documentation technique](../doc.md)

## 🎓 Sessions de formation

- Une session correspond à une **formation programmée à une date donnée**
- Une session est liée à **un ou plusieurs services** (ex: RH, Informatique)
- Une session peut avoir une capacité maximale d'inscrits

## 👥 Utilisateurs et services

- Chaque utilisateur est rattaché à **un service**

## 📆 Inscriptions

- Un utilisateur peut s'inscrire une session s'il ya des places disponibles et si la formation dont cette session dépend est visible

## 🛠️ Gestion des droits

- `ROLE_USER` : voir et s'inscrire les sessions de son service
- `ROLE_RH` : gérer les formations, les sessions, les participations et la visibilité des sessions ainsi que tous les droits de `ROLE_RH`
- `ROLE_ADMIN` : gérer tous les utilisateurs, les salles et les services ainsi que tous les droits de `ROLE_RH`