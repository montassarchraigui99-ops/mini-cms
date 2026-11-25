# Session 10 - Robustesse

TagAdminTest contient 5 tests verts : oui
/posts/categorie/inconnue affiche Catégorie introuvable avec le statut 404 : oui
php artisan test est vert : oui

1. Pourquoi le message de messages() l'emporte-t-il sur celui de lang/fr/validation.php ?
Parce que Laravel ajoute les messages définis dans la FormRequest (la méthode messages()) avant ceux du fichier de traduction : pour la clé slug.unique, c'est le texte propre aux tags qui est utilisé. lang/fr/validation.php reste le repli pour les règles qui n'ont pas de message personnalisé.

2. Pourquoi phpunit.xml fixe-t-il APP_LOCALE ?
Pour que les tests soient reproductibles et indépendants du .env de la machine : la variable est injectée avant le démarrage de l'application, donc les messages sont toujours ceux de lang/fr, y compris en intégration continue ou si un développeur travaille dans une autre langue.

3. Pourquoi CategoryController n'a-t-il besoin d'aucun try/catch ?
Le binding de modèle lève ModelNotFoundException quand le slug n'existe pas ; Laravel la convertit en NotFoundHttpException et le callback render de bootstrap/app.php renvoie la vue errors/categorie-introuvable avec le statut 404. Le contrôleur n'est donc jamais appelé avec un modèle manquant : il n'a rien à intercepter.
