# Documentation technique

- [Principal](../README.md)
- [Résoudre les erreurs](./errors/README.md)

## Modèle Logique de Données

- `formation` (<u>**id**</u>, titre, description, imageURL, estVisible, **#formateur_id**)
- `parametre` (<u>**id**</u>, nom, valeur, commentaires)
- `participation` (<u>**id**</u>, **#utilisateur_id, #session_id**, date_inscription, objectifs, estPresent)
- `salle` (<u>**id**</u>, nom, batiment, nb_places_max)
- `service` (<u>**id**</u>, nom, email)
- `session` (<u>**id**</u>, titre, heure_debut, heure_fin, nb_participants_max, statut_session, **#formation_id**, **#salle_id**)
- `utilisateur` (<u>**id**</u>, prenom, nom, email, password, roles, **#service_id**)
- `visibilite` (<u>**id**</u>, **#service_id, #session_id**)