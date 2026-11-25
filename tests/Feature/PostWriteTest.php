<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;

beforeEach(function () {
    $this->withoutVite();
    $this->actingAs(User::factory()->admin()->create());
});

function writePostData(array $overrides = []): array
{
    return array_merge([
        'title' => 'Article de test',
        'slug' => 'article-de-test',
        'body' => 'Contenu suffisamment long pour passer la validation.',
        'is_published' => '1',
    ], $overrides);
}

it('creates a post with its category and tags', function () {
    $category = Category::factory()->create();
    $tag = Tag::factory()->create();

    $this->post(route('posts.store'), writePostData([
        'category_id' => $category->id,
        'tags' => [$tag->id],
    ]))->assertRedirect();

    $post = Post::where('slug', 'article-de-test')->firstOrFail();
    expect($post->category_id)->toBe($category->id);
    expect($post->tags->pluck('id')->all())->toEqual([$tag->id]);
});

it('ignores fields that are not in the validation rules', function () {
    $this->post(route('posts.store'), writePostData(['user_id' => 999]))
        ->assertRedirect();

    $post = Post::where('slug', 'article-de-test')->firstOrFail();
    expect($post->user_id)->toBe(auth()->id());
});

it('returns to the form with errors and old input for an empty title', function () {
    $this->post(route('posts.store'), writePostData(['title' => '']))
        ->assertRedirect()
        ->assertSessionHasErrors('title')
        ->assertSessionHasInput('slug', 'article-de-test');

    $this->assertDatabaseMissing('posts', ['slug' => 'article-de-test']);
});

it('rejects a duplicate slug', function () {
    Post::factory()->create(['slug' => 'article-de-test']);

    $this->post(route('posts.store'), writePostData())
        ->assertSessionHasErrors('slug');
});

it('keeps its own slug when the article is updated', function () {
    $post = Post::factory()->create(['slug' => 'article-de-test']);

    $this->put(route('posts.update', $post), writePostData(['title' => 'Titre modifié']))
        ->assertRedirect(route('posts.show', $post));

    expect($post->refresh()->slug)->toBe('article-de-test');
});

it('rejects the slug of another article on update', function () {
    $post = Post::factory()->create(['slug' => 'article-de-test']);
    $other = Post::factory()->create(['slug' => 'article-de-jaune']);

    $this->put(route('posts.update', $post), writePostData(['slug' => $other->slug]))
        ->assertSessionHasErrors('slug');
});
