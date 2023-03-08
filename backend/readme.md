
## Installation de la BDD avec fixtures :
***
**Avant de faire une commande :**
```
composer install
```
**Si la base de données n'est pas encore créer vous pouvez faire cette commande :**
```
php bin/console doctrine:database:create
```
***
**Chargement des fixtures et installation de la BDD**
```
php bin/console doctrine:s:u --force
php bin/console doctrine:fixtures:load
```

***
### Endpoint intéressant :
Récupérer les réservations sur un material spécifique : 
```
/api/reservations?material=idMaterial
```
Récupérer toutes les réservations (10 par pages) :
```
/api/reservations
```
Récupérer tous les matériels (30 par pages) :
```
/api/materials
```
Récupérer toutes les marques sur :
```
/api/brands
```
Récupérer tous les types de matériels :
```
/api/material_types
```
Poster une réservation : 
```
/api/reservations

{
  "material": "/api/materials/idMaterial",
  "startDate": "2023-03-07",
  "endDate": "2023-03-07",
  "emailBorrower": "emilien.muck@gmail.com",
  "statutBorrower": "ext",
  "firstName": "Emilien",
  "lastName": "Muckensturm"
}
```