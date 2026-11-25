# Session 09 - Défi

Le bandeau s'affiche sur toutes les pages quand SITE_READ_ONLY=true : oui
Le bandeau disparaît quand SITE_READ_ONLY=false : oui
La page Article introuvable propose au plus trois articles publiés, sans brouillon : oui
Aucune LazyLoadingViolationException sur /posts/999 : oui
Les deux nouveaux tests passent et php artisan test est vert : oui

Pourquoi le bandeau est-il dans le layout et pas dans chaque vue ?
Le layout est le seul fichier commun à toutes les pages : une information qui concerne tout le site (message flash, bandeau d'état) n'a besoin que d'un seul bloc de code. Ajouter le bandeau dans chaque vue obligerait à le répéter et risquerait d'oublier une page. Le bandeau est placé avant le message flash pour que l'état du site soit lu en premier.

Pourquoi le test du bandeau n'a-t-il pas besoin de modifier .env ?
Le test modifie la configuration en mémoire avec config()->set('site.read_only', true), ce qui suffit pour le rendu de la réponse. phpunit.xml impose SITE_READ_ONLY=false aux tests : ils ne doivent jamais écrire dans .env, qui n'est pas versionné et est utilisé par le serveur de développement.
