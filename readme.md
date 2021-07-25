# Projet Gamer
Création d'un site web référencant différents jeux vidéo et permettant à ses utilisateurs de les noter. Une note moyenne répresentative sera alors créé pour les prochaines personnes qui souhaitent des informations sur le jeux souhaité. 

## Objectifs 
- Création d'un système d'inscription et de connection
- Envoi d'un mail de validation lors de l'inscription
- Système de cookies
- Création d'une liste de jeux vidéo contenant nom, description et photo ainsi que leurs moyennes de notes
- Création du profil utilisateur avec pseudo, mail et password
- Gestion des listes de jeux notés par les utilisateurs

# Etape 1 

## Install
```bash
 composer create-project symfony/website-skeleton gamer
 ```

## Création des entités 

 ```bash
symfony console make:entity (Name)
 ```

## Migrations

```bash
symfony console make:migration
symfony console doctrine:migrations:migrate
```

 ## Configuration Base De Donnée

 ```bash
# On tape symfony console doctrine et on nous donne :
composer require symfony/orm-pack
# Le fichier env à été modifié (on va pouvoir créer les connections)
DATABASE_URL="mysql://root:@127.0.0.1:3306/db_gamer"
# puis
symfony console doctrine:database:create
```

## Créer le controller/Répository/Vues

```bash
symfony console make:crud (EntityName)
```
