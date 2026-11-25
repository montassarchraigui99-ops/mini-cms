<x-layout>
    <x-slot:title>Accueil - Mini-CMS</x-slot:title>

    <section class="mb-10 rounded-lg bg-white border border-gray-200 p-8 shadow-sm">
        <h1 class="text-3xl font-bold text-gray-900">Bienvenue sur Mini-CMS</h1>
        <p class="mt-2 text-gray-600">Découvrez nos derniers articles publiés et parcourez les contenus par catégorie.</p>
        <div class="mt-4 flex gap-3">
            <a href="{{ route('posts.index') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">Voir tous les articles</a>
            <a href="{{ route('posts.create') }}" class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Nouvel article</a>
        </div>
    </section>

    <h2 class="text-2xl font-bold mb-4">Parcourir par catégorie</h2>
    <ul class="mb-10 flex flex-wrap gap-3" aria-label="Catégories">
        @foreach ($categories as $category)
            <li>
                <a href="{{ route('posts.category', $category) }}" class="inline-block rounded-md border border-gray-300 bg-white px-3 py-1.5 text-sm text-gray-700 hover:border-indigo-600 hover:text-indigo-600">{{ $category->name }} ({{ $category->posts_count }})</a>
            </li>
        @endforeach
    </ul>

    @if ($tags->isNotEmpty())
        <h2 class="text-2xl font-bold mb-4">Tags populaires</h2>
        <ul class="mb-10 flex flex-wrap gap-3" aria-label="Tags populaires">
            @foreach ($tags as $tag)
                <li>
                    <a href="{{ route('posts.tag', $tag) }}" class="inline-block rounded-md border border-gray-300 bg-white px-3 py-1.5 text-sm text-gray-700 hover:border-indigo-600 hover:text-indigo-600">{{ $tag->name }} ({{ $tag->posts_count }})</a>
                </li>
            @endforeach
        </ul>
    @endif

    <h2 class="text-2xl font-bold mb-4">Derniers articles publiés</h2>
    <div class="grid gap-6 md:grid-cols-3">
        @forelse ($latestPosts as $post)
            <x-post-card :post="$post" />
        @empty
            <x-alert type="warning" title="Aucun article" class="md:col-span-3">
                Aucun article publié pour le moment.
            </x-alert>
        @endforelse
    </div>
</x-layout>
