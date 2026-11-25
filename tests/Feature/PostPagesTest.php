<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;

beforeEach(function () {
    $this->withoutVite();
});

it('shows the posts list', function () {
    Post::create([
        'title' => 'Premier article',
        'slug' => 'premier-article',
        'body' => 'Contenu du premier article de test.',
        'is_published' => true,
        'published_at' => now(),
    ]);

    $this->get(route('posts.index'))
        ->assertOk()
        ->assertSee('Premier article');
});

it('shows a message when there is no post', function () {
    $this->get(route('posts.index'))
        ->assertOk()
        ->assertSee('Aucun article');
});

it('shows a single post', function () {
    $post = Post::create([
        'title' => 'Article complet',
        'slug' => 'article-complet',
        'body' => 'Texte complet de cet article de test.',
        'is_published' => true,
        'published_at' => now(),
    ]);

    $this->get(route('posts.show', $post))
        ->assertOk()
        ->assertSee('Texte complet de cet article de test.');
});

it('returns 404 for an unknown post', function () {
    $this->get('/posts/999')->assertNotFound();
});

it('shows the create form', function () {
    $this->get(route('posts.create'))
        ->assertOk()
        ->assertSee('Nouvel article');
});

it('creates a post with a category and tags', function () {
    $category = Category::create(['name' => 'PHP', 'slug' => 'php']);
    $tagA = Tag::create(['name' => 'Astuce', 'slug' => 'astuce']);
    $tagB = Tag::create(['name' => 'Sécurité', 'slug' => 'securite']);

    $response = $this->post(route('posts.store'), [
        'title' => 'Article avec relations',
        'slug' => 'article-avec-relations',
        'body' => 'Contenu suffisamment long pour passer la validation.',
        'category_id' => $category->id,
        'tags' => [$tagA->id, $tagB->id],
        'is_published' => '1',
    ]);

    $post = Post::where('slug', 'article-avec-relations')->firstOrFail();

    $response->assertRedirect(route('posts.show', $post));
    expect($post->category_id)->toBe($category->id);
    expect($post->tags->pluck('id')->all())->toEqualCanonicalizing([$tagA->id, $tagB->id]);
});

it('rejects an unknown category_id', function () {
    $this->post(route('posts.store'), [
        'title' => 'Article invalide',
        'slug' => 'article-invalide',
        'body' => 'Contenu suffisamment long pour passer la validation.',
        'category_id' => 999,
    ])->assertSessionHasErrors('category_id');
});

it('updates a post and clears tags when none are checked', function () {
    $category = Category::create(['name' => 'Laravel', 'slug' => 'laravel']);
    $tag = Tag::create(['name' => 'Débutant', 'slug' => 'debutant']);
    $post = Post::create([
        'title' => 'Ancien titre',
        'slug' => 'ancien-titre',
        'body' => 'Contenu initial de test pour cet article.',
        'category_id' => $category->id,
        'is_published' => true,
        'published_at' => now(),
    ]);
    $post->tags()->sync([$tag->id]);

    $this->put(route('posts.update', $post), [
        'title' => 'Nouveau titre',
        'slug' => 'ancien-titre',
        'body' => 'Contenu mis à jour pour cet article de test.',
        'category_id' => '',
        'is_published' => '1',
    ])->assertRedirect(route('posts.show', $post));

    $post->refresh();
    expect($post->category_id)->toBeNull();
    expect($post->tags)->toHaveCount(0);
});

it('shows only published posts for a category slug and 404 for unknown slug', function () {
    $laravel = Category::create(['name' => 'Laravel', 'slug' => 'laravel']);

    Post::create([
        'title' => 'Article publié Laravel',
        'slug' => 'article-publie-laravel',
        'body' => 'Contenu publié dans la catégorie Laravel.',
        'category_id' => $laravel->id,
        'is_published' => true,
        'published_at' => now(),
    ]);

    Post::create([
        'title' => 'Brouillon Laravel',
        'slug' => 'brouillon-laravel',
        'body' => 'Contenu brouillon dans la catégorie Laravel.',
        'category_id' => $laravel->id,
        'is_published' => false,
        'published_at' => null,
    ]);

    $this->get(route('posts.category', $laravel))
        ->assertOk()
        ->assertSee('Catégorie : Laravel')
        ->assertSee('Article publié Laravel')
        ->assertDontSee('Brouillon Laravel');

    $this->get('/posts/categorie/inconnue')->assertNotFound();
});

it('shows categories with published post counts on the home page', function () {
    $laravel = Category::create(['name' => 'Laravel', 'slug' => 'laravel']);

    Post::create([
        'title' => 'Publié 1',
        'slug' => 'publie-1',
        'body' => 'Contenu du premier article publié.',
        'category_id' => $laravel->id,
        'is_published' => true,
        'published_at' => now(),
    ]);

    Post::create([
        'title' => 'Brouillon 1',
        'slug' => 'brouillon-1',
        'body' => 'Contenu du brouillon non compté.',
        'category_id' => $laravel->id,
        'is_published' => false,
        'published_at' => null,
    ]);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Laravel (1)')
        ->assertSee('Publié 1')
        ->assertDontSee('Brouillon 1');
});