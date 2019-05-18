# URL du projet

`https://louvres-openclassrooms.com`

# Installation du projet en local

- Récupérer le projet sur Github en faisant

`git clone https://github.com/YoannDelion/projet4.git`

- Installer les dépendances avec la commande suivante
 
`composer install`

- Installer la base de données liées au projet

```
php bin/console doctrine:database:create
php bin/console doctrine:database:update
```

- Lancer le serveur Symfony local

`php bin/console server:run`

Le projet est disponible à l'adresse `http://127.0.0.1:8000/`
