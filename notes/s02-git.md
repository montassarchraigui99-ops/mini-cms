# Session 02 - Git et GitHub

Réponses rédigées avec mes propres mots, puis comparées au corrigé de la page.

## 1. Index et commit

Réponse : git add fait passer les modifications du répertoire de travail vers l'index, et git commit enregistre les modifications de l'index dans le dépôt local (git push envoie ensuite vers le dépôt distant).

## 2. Branche et tag

Réponse : Une branche avance automatiquement à chaque commit ; un tag reste fixé de manière permanente sur un commit spécifique (ex. lab-01 désigne l'état du projet à la fin de la session 01).

## 3. Le fichier .env

Réponse : Le fichier .env contient des réglages propres au poste (APP_KEY, configurations de base de données) et des secrets en production. Un autre développeur copie .env.example vers .env puis exécute php artisan key:generate.

## 4. Le dossier vendor/

Réponse : vendor/ contient les dépendances PHP externes, c'est un dossier lourd et entièrement généré. Il n'est pas versionné car composer.lock enregistre les versions exactes et composer install le reconstruit à l'identique.

## 5. Git Credential Manager

Réponse : Git Credential Manager stocke le jeton GitHub de manière sécurisée dans le Gestionnaire d'identification Windows (entrée git:https://github.com). Il faut le supprimer en fin de séance sur un poste partagé ou de l'université pour éviter qu'un autre utilisateur n'effectue des commits ou des pushs en notre nom.
