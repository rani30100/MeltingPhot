# MeltingPhot

## Introduction

MeltingPhot est un site internet que j'ai réalisé auprès de l'association MeltingPhot situé sur Alès au 15 Rte de Bagnols.

L'association MeltingPhot mène des actions éducatives auprès des jeunes afin de leur faire découvrir les métiers de leur région et au-delà. Elle propose des activités telles que des interviews, des reportages et l'édition de magazines, tous centrés sur la thématique des métiers qui recrutent.

Les coordonées pour joindre l'équipe MeltingPhot :
https://www.linkedin.com/in/meltingphot/

Retrouvez leurs actions sur la chaine Youtube : 
https://www.youtube.com/@meltingphot

## Technologies utilisées

- PHP
- Symfony
- HTML/CSS/JS
- Bootstrap
- Google API

## Fonctionnalités


1. **Intégration avec l'API YouTube** - Le projet se connecte à l'API YouTube pour récupérer les vidéos et les détails associés.

2. **Interface utilisateur réactive** - Le projet utilise Bootstrap pour une interface utilisateur réactive et élégante.

3. **Chargement différé des vidéos** - Le projet implémente un chargement différé pour les vidéos (Observer), ce qui améliore les performances de chargement de la page.

4. **Prévention CSRF** - Le projet utilise une prévention CSRF pour sécuriser les formulaires de connexion.



## Technologies utilisées

**PHP** : Un langage de script populaire pour le développement web. <a href="https://www.php.net/docs.php">Documentation PHP</a>

**Symfony** : Un framework PHP pour le développement d'applications web. <a href="https://symfony.com/doc/current/index.html">Documentation Symfony</a>

**HTML/CSS/JS** : Les technologies de base pour le développement de sites web. <a href="https://developer.mozilla.org/fr/docs/Web/HTML">Documentation HTML</a>, <a href="https://developer.mozilla.org/fr/docs/Web/CSS">Documentation CSS</a>, <a href="https://developer.mozilla.org/fr/docs/Web/JavaScript">Documentation JavaScript</a>

**Bootstrap** : Un framework CSS pour le développement d'interfaces utilisateur réactives. <a href="https://getbootstrap.com/">Documentation Bootstrap</a>

**Google API** : L'API Google pour accéder à différentes fonctionnalités de Google, y compris YouTube. <a href="https://developers.google.com/youtube/v3?hl=fr">Documentation Google APIs</a>

## Comment configurer le projet

1. **Clonez le dépôt**

    ```sh
    git clone https://github.com/your-username/MeltingPhot.git
    ```

2. **Accédez au dossier du projet**

    ```sh
    cd MeltingPhot
    ```

3. **Installez les dépendances**

    ```sh
    composer install
    npm install
    ```

4. **Configurez votre fichier .env**

    Assurez-vous de définir vos variables d'environnement, en particulier celles liées à la base de données et à l'API YouTube.

5. **Créez la base de données et effectuez les migrations**

    ```sh
    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate
    ```

6. **Lancez le serveur de développement**

    ```sh
    symfony server:start
    ```

    Le projet devrait maintenant être accessible à `http://localhost:8000`.

## Me contacter
linkedin : https://www.linkedin.com/in/rani-d-a35bb71b3/

## Soutien
Personnes qui m'ont aidé à la réalisation de mon projet :
https://github.com/VincentSureau --VINCENT SUREAU
https://github.com/citrusMarmelade --EMMANUEL ARMENGAUD


