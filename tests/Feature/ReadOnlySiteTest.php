<?php

use App\Models\Post;
use App\Models\User;

beforeEach(function () {
    $this->withoutVite();
    $this->actingAs(User::factory()->admin()->create());
});

it('allows writes by default in the test suite', function () {
    expect(config('site.read_only'))->toBeFalsy();

    $this->post(route('posts.store'), [
        'title' => 'Article en écriture',
        'slug' => 'article-en-ecriture',
        'body' => 'Contenu suffisamment long pour passer la validation.',
    ])->assertRedirect();
});

it('blocks write methods with 503 when the site is read only', function (string $method, string $uri) {
    config()->set('site.read_only', true);
    $post = Post::factory()->create();
    $target = str_replace('{post}', (string) $post->id, $uri);

    $this->call($method, $target)->assertStatus(503);
})->with([
    'POST' => ['POST', '/posts'],
    'PUT' => ['PUT', '/posts/{post}'],
    'PATCH' => ['PATCH', '/posts/{post}/publication'],
    'DELETE' => ['DELETE', '/posts/{post}'],
]);

it('still serves the articles list when the site is read only', function () {
    config()->set('site.read_only', true);

    $this->get(route('posts.index'))->assertOk();
});
