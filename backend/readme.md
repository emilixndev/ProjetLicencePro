
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
php bin/console doctrine:migrations:migrate
php bin/console doctrine:s:u --force
php bin/console doctrine:fixtures:load
```
