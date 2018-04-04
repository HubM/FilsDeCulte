# FilsDeCulte

FilsDeCulte est un bot automatisé qui va spoiler vos amis en se basant sur un titre de film/série donné.

## Installation

L'installation du projet se fait en différentes parties : 

- Clone du dépot && installation des dépendances.   
```
 	git clone https://github.com/HubM/FilsDeCulte.git  
 	cd FilsDeCulte  
	composer install    
```

- Création d'une base de donnée vierge avec mysql-cli ou un outil comme phpmyadmin   
```
	mysql -u*usernameMYSQL* -p*passwordMYSQL*    
	CREATE TABLE filsdeculte  
```

- Création d'un fichier de configuration propre à votre environnement (.env)  
 Afin de vous aider, Laravel propose un exemple (.env.example), il suffit donc de le copier et de modifier les informations  
 liées à votre base de données (MYSQL).    
```
	DB_CONNECTION=mysql  
	DB_HOST=127.0.0.1  
	DB_PORT=*Votre port mysql*  
	DB_DATABASE=filsdeculte  
	DB_USERNAME=*usernameMYSQL*  
	DB_PASSWORD=*passwordMYSQL*       
```

- Le projet utilise une lib qui permet de communiquer avec l'API Twitter. Pour la faire fonctionner nous avons besoin  
de spécifier les clés d'api fournit par twitter. Il faut donc rajouter ces lignes dans notre .env :   
```
	TWITTER_CONSUMER_KEY=b6eCa4IidfrAE6AdYvx92cvcO
	TWITTER_CONSUMER_SECRET=YAhCjOtCS652JGcyfXfFUMSxKXI3Vc23QP0cd3hhVI4YPvF5wn
	TWITTER_ACCESS_TOKEN=964112547589820416-F12WQr1MYtrFZMYVtgdtf0gd7A1ugj7
	TWITTER_ACCESS_TOKEN_SECRET=2GEaFUFi0Hew0iFPevkjUjuqH7f9QEPwQRWJX742fGq4C
```

- Laravel se base sur des systèmes de migrations qui permettent d'automatiser les tâches propres à la base de donné (ajout/modification/suppression de table/). Ainsi pour peupler la base de donnée que nous venons de créer, nous allons lancer la commande ```php artisan migrate``` qui va appliquer les migratiosn dans notre bdd.

- Lancer le projet  
Pour lancer le projet il faut lancer la commande ```php artisan serve```. Cette commande va lancer un serveur disponible sur le port **8000** du localhost.  

***NB :*** Si vous rencontrez une erreur comme *No application encryption key has been specified*, il faudra alors utiliser la commande ```php artisan key:generate``` pour générer une clé. Il suffira alors de copier cette clé (ex: *base64:W56DvSuihWx6E73bmRvsLLXp9Mv24HBZ6zma1d/tr+o=*) et l'ajouter dans votre fichier .env, dans APP_KEY comme ceci :  
```
APP_KEY=base64:W56DvSuihWx6E73bmRvsLLXp9Mv24HBZ6zma1d/tr+o=
```

Réessayer ensuite de relancer ```php artisan serve``` et rendez-vous sur [ici](http://localhost:8000)

## Lancement de la commande  

Une fois l'installation reussi (affichage de la page d'accueil sur l), nous devons tester que la commande qui execute toutes les actions de  
récupération et de tri des tweets fonctionnent.


- Lancer la commande ```php artisan tweets:get```. Si vous n'avez pas de réponse ou d'erreur, c'est que la commande marche. 










