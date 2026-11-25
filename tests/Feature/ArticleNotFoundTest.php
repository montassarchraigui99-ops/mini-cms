<?php

beforeEach(function () {
    $this->withoutVite();
});

it('shows the dedicated page for a missing post', function () {
    $this->get('/posts/999')
        ->assertNotFound()
        ->assertSee('Article introuvable')
        ->assertDontSee('Not Found');
});

it('keeps the standard 404 page for a missing category', function () {
    $this->get('/posts/categorie/inconnue')
        ->assertNotFound()
        ->assertSee('Not Found')
        ->assertDontSee('Article introuvable');
});

it('lets Laravel return a JSON error for a missing post', function () {
    $response = $this->getJson('/posts/999')->assertNotFound();

    expect($response->headers->get('content-type'))->toContain('application/json');
});
