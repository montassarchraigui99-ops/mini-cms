<?php

use App\Models\Post;
use App\Models\User;

beforeEach(function () {
    $this->withoutVite();
    $this->actingAs(User::factory()->admin()->create());
});

function flashPostData(array $overrides = []): array
{
    return array_merge([
        'title' => 'Article flash',
        'slug' => 'article-flash',
        'body' => 'Contenu suffisamment long pour passer la validation.',
        'is_published' => '1',
    ], $overrides);
}

it('shows the creation message on the next page only', function () {
    $this->post(route('posts.store'), flashPostData())->assertRedirect();

    $post = Post::where('slug', 'article-flash')->firstOrFail();

    $this->get(route('posts.show', $post))
        ->assertSee('Article créé.')
        ->assertSee('role="status"', false);

    $this->get(route('posts.show', $post))
        ->assertDontSee('Article créé.');
});

it('shows the update message after editing', function () {
    $post = Post::factory()->create(['slug' => 'article-flash']);

    $this->put(route('posts.update', $post), flashPostData(['title' => 'Titre mis à jour']))
        ->assertRedirect(route('posts.show', $post));

    $this->get(route('posts.show', $post))->assertSee('Article mis à jour.');
});

it('shows the publication message matching the new state', function (bool $published, string $message) {
    $post = Post::factory()->create([
        'slug' => 'article-flash',
        'is_published' => ! $published,
    ]);

    $this->patch(route('posts.publication', $post))
        ->assertRedirect(route('posts.show', $post));

    $this->get(route('posts.show', $post))->assertSee($message);
})->with([
    'published' => [true, 'Article publié.'],
    'unpublished' => [false, 'Article dépublié.'],
]);

it('shows the deletion message on the posts list', function () {
    $post = Post::factory()->create(['slug' => 'article-flash']);

    $this->delete(route('posts.destroy', $post))
        ->assertRedirect(route('posts.index'));

    $this->get(route('posts.index'))->assertSee('Article supprimé.');
});
