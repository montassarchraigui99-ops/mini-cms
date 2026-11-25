<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // --- 3 Users ---
        $alice = User::firstOrCreate(
            ['email' => 'alice@example.com'],
            ['name' => 'Alice Martin', 'password' => bcrypt('password')]
        );
        $bob = User::firstOrCreate(
            ['email' => 'bob@example.com'],
            ['name' => 'Bob Dupont', 'password' => bcrypt('password')]
        );
        $charlie = User::firstOrCreate(
            ['email' => 'charlie@example.com'],
            ['name' => 'Charlie Leroy', 'password' => bcrypt('password')]
        );

        // --- 4 Categories ---
        $categories = collect([
            ['name' => 'Base de données', 'slug' => 'base-de-donnees'],
            ['name' => 'Laravel',         'slug' => 'laravel'],
            ['name' => 'PHP',             'slug' => 'php'],
            ['name' => 'Sécurité',        'slug' => 'securite'],
        ])->mapWithKeys(fn (array $data) => [
            $data['slug'] => Category::firstOrCreate(['slug' => $data['slug']], $data),
        ]);

        // --- 6 Tags ---
        $tags = collect([
            ['name' => 'Astuce',    'slug' => 'astuce'],
            ['name' => 'Avancé',    'slug' => 'avance'],
            ['name' => 'Débutant',  'slug' => 'debutant'],
            ['name' => 'Migration', 'slug' => 'migration'],
            ['name' => 'Sécurité',  'slug' => 'securite'],
            ['name' => 'Tests',     'slug' => 'tests'],
        ])->mapWithKeys(fn (array $data) => [
            $data['slug'] => Tag::firstOrCreate(['slug' => $data['slug']], $data),
        ]);

        // --- 12 Posts (9 published, 3 drafts) with 24 post_tag entries ---
        $posts = [
            [
                'title' => 'Bien démarrer avec Laravel',
                'slug' => 'bien-demarrer-avec-laravel',
                'body' => 'Laravel simplifie le développement web grâce au routage, à Eloquent et aux vues Blade.',
                'is_published' => true, 'published_at' => now()->subDays(12),
                'user_id' => $alice->id, 'category_id' => $categories['laravel']->id,
                'tags' => [$tags['debutant']->id, $tags['astuce']->id],
            ],
            [
                'title' => 'Typage strict en PHP 8',
                'slug' => 'typage-strict-en-php-8',
                'body' => 'Le typage strict et les types de retour améliorent la fiabilité et la lisibilité du code PHP.',
                'is_published' => true, 'published_at' => now()->subDays(11),
                'user_id' => $bob->id, 'category_id' => $categories['php']->id,
                'tags' => [$tags['astuce']->id, $tags['avance']->id],
            ],
            [
                'title' => 'Valider les entrées utilisateur',
                'slug' => 'valider-les-entrees-utilisateur',
                'body' => 'Toujours valider côté serveur avec les règles Laravel comme exists, integer et unique.',
                'is_published' => true, 'published_at' => now()->subDays(10),
                'user_id' => $alice->id, 'category_id' => $categories['securite']->id,
                'tags' => [$tags['securite']->id, $tags['tests']->id],
            ],
            [
                'title' => 'Les migrations pas à pas',
                'slug' => 'les-migrations-pas-a-pas',
                'body' => 'Chaque migration représente un changement de schéma versionné et réversible de la base de données.',
                'is_published' => true, 'published_at' => now()->subDays(9),
                'user_id' => $charlie->id, 'category_id' => $categories['base-de-donnees']->id,
                'tags' => [$tags['debutant']->id, $tags['migration']->id],
            ],
            [
                'title' => 'Eloquent et les relations',
                'slug' => 'eloquent-et-les-relations',
                'body' => 'BelongsTo, HasMany et BelongsToMany couvrent la plupart des cas de figure dans une application Laravel.',
                'is_published' => true, 'published_at' => now()->subDays(8),
                'user_id' => $alice->id, 'category_id' => $categories['laravel']->id,
                'tags' => [$tags['avance']->id, $tags['astuce']->id],
            ],
            [
                'title' => 'Protéger ses routes avec middleware',
                'slug' => 'proteger-ses-routes-avec-middleware',
                'body' => 'Les middleware filtrent les requêtes HTTP avant qu\'elles n\'atteignent le contrôleur.',
                'is_published' => true, 'published_at' => now()->subDays(7),
                'user_id' => $bob->id, 'category_id' => $categories['securite']->id,
                'tags' => [$tags['securite']->id, $tags['avance']->id],
            ],
            [
                'title' => 'Tester avec Pest',
                'slug' => 'tester-avec-pest',
                'body' => 'Pest rend les tests PHP expressifs et rapides grâce à une syntaxe fonctionnelle et des helpers intégrés.',
                'is_published' => true, 'published_at' => now()->subDays(6),
                'user_id' => $charlie->id, 'category_id' => $categories['laravel']->id,
                'tags' => [$tags['tests']->id, $tags['debutant']->id],
            ],
            [
                'title' => 'Les nouveautés de PHP 8.3',
                'slug' => 'les-nouveautes-de-php-83',
                'body' => 'PHP 8.3 apporte les constantes typées dans les classes, json_validate() et la méthode getBytesFromString().',
                'is_published' => true, 'published_at' => now()->subDays(5),
                'user_id' => $alice->id, 'category_id' => $categories['php']->id,
                'tags' => [$tags['astuce']->id, $tags['avance']->id],
            ],
            [
                'title' => 'Indexer ses tables SQLite',
                'slug' => 'indexer-ses-tables-sqlite',
                'body' => 'Un index bien placé peut diviser le temps de réponse d\'une requête par dix sur des tables volumineuses.',
                'is_published' => true, 'published_at' => now()->subDays(4),
                'user_id' => $bob->id, 'category_id' => $categories['base-de-donnees']->id,
                'tags' => [$tags['avance']->id, $tags['migration']->id],
            ],
            [
                'title' => 'Brouillon : API RESTful',
                'slug' => 'brouillon-api-restful',
                'body' => 'Concevoir une API RESTful avec les ressources API de Laravel et les bonnes pratiques de nommage.',
                'is_published' => false, 'published_at' => null,
                'user_id' => $alice->id, 'category_id' => $categories['laravel']->id,
                'tags' => [$tags['avance']->id, $tags['astuce']->id],
            ],
            [
                'title' => 'Brouillon : Hachage sécurisé',
                'slug' => 'brouillon-hachage-securise',
                'body' => 'Comprendre bcrypt, Argon2 et les bonnes pratiques de stockage des mots de passe en PHP.',
                'is_published' => false, 'published_at' => null,
                'user_id' => $bob->id, 'category_id' => $categories['securite']->id,
                'tags' => [$tags['securite']->id, $tags['debutant']->id],
            ],
            [
                'title' => 'Brouillon : Vues composites',
                'slug' => 'brouillon-vues-composites',
                'body' => 'Assembler des composants Blade réutilisables pour construire des interfaces complexes sans duplication.',
                'is_published' => false, 'published_at' => null,
                'user_id' => $charlie->id, 'category_id' => $categories['php']->id,
                'tags' => [$tags['astuce']->id, $tags['tests']->id],
            ],
        ];

        foreach ($posts as $item) {
            $tagIds = $item['tags'];
            unset($item['tags']);

            $post = Post::firstOrCreate(['slug' => $item['slug']], $item);
            $post->tags()->sync($tagIds);
        }
    }
}
