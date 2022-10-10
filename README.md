Récapitulatif :

Développement d'un site communautaire de partage de figure de snowboard pour faire connaître ce sport auprès du grand public et aider à l'apprentissage.

Pour ce projet, nous allons nous concentrer sur la création technique du site.

Description du besoin : 

Développer le site répondant aux besoins en implémentant les fonctionnalités suivantes : 

- Un annuaire des figures de snowboard. Intégration de quelques figures, le reste sera saisi par les internautes.

- La gestion des figures (création, modification, visualisation).

- Un espace de discussion commun (commentaires) à toutes les figures.


Pour implémenter ces fonctionnalités, création des pages suivantes :


- La page d’accueil où figurera la liste des figures.
 
- La page de création d'une nouvelle figure.
 
- La page de modification d'une figure.
 
- La page de visualisation d’une figure (contenant l’espace de discussion commun autour de la figure).

- La page d'inscription.

- La page d'édition de compte utilisateur.

- Une page d'index des figures correspondant à l'utilisateur connecté.

- La page de connexion.

- La page des mentions légales.



Outils Requis :

- PHP version >= 8.0

- Composer version >= 2.4.1

- Symfony CLI version >= 5.4.13

- WampServer

- MySQL version >= 8.0.29

- PHPMyAdmin



Installation : 

- Ouvrez une interface de commande et cloner le repository dans un dossier ( "git clone https://github.com/Valentin-Leca/PHP-SF-Snowtricks.git" )

- Se placer à la racine du projet et faire un "composer install" pour installer tous les bundles associés au projet présent dans le fichier composer.lock

- Faites une copie de votre fichier .env que vous renommez en '.env.local' et modifiez la partie "DATABASE_URL" avec vos informations de base de données (nom  utilisateur, mdp, nom de la bdd ...). Si vous utilisez le mailer, modifiez aussi la partie "MAILER_DSN".

- Faire la commande "php bin/console doctrine:schema:create" pour créer la base de donnée.

- Lancer la commande "symfony console doctrine:fixtures:load" pour créer les données de test (compte utilisateur, figure, commentaires ...)

Une fois ces étapes réalisées, lancer WampServer puis faites "symfony serve -d" en ligne de commande à la racine du projet.

Rendez-vous sur votre navigateur, en localhost (port par défaut de Symfony : 8000) -> https://127.0.0.1:8000/ ou alors https://localhost:8000/ et découvrez le site !

