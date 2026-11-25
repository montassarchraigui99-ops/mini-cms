# Session 08 - Défi

La route posts.tag utilise {tag:slug} : oui
La page d'un tag n'affiche ni brouillon ni article d'un autre tag : oui
Les tags des cartes sont des liens : oui
L'accueil n'affiche que les tags qui ont au moins un article publié : oui
Les trois nouveaux tests passent et php artisan test est vert : oui

Pourquoi filtrer les tags vides après get() plutôt que d'afficher (0) ?
> Un tag sans aucun article publié n'est pas « populaire » : l'afficher avec `(0)` mènerait vers une page vide et encombrerait l'accueil. Filtrer après `get()` (avec `filter(fn (Tag $tag) => $tag->posts_count > 0)`) reste simple, lisible et portable entre SQLite, MySQL et PostgreSQL sans dépendre d'un `HAVING` sur un alias de sous-requête.

Combien de requêtes ajoute la liste des tags populaires, et pourquoi pas une par tag ?
> Elle ajoute **une seule requête** SQL : `Tag::withCount(['posts' => fn (Builder $query) => $query->published()])` calcule `posts_count` directement via une sous-requête corrélée dans la requête sur `tags`, sans jamais charger les articles et sans déclencher de problème N+1 (qui provoquerait une `LazyLoadingViolationException`).
