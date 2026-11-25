<x-layout>
    <x-slot:title>{{ $post->title }} - Mini-CMS</x-slot:title>

    <article class="max-w-2xl">
        <a href="{{ route('posts.index') }}" class="text-sm text-indigo-600 hover:underline">Retour aux articles</a>

        <div class="mt-4 flex items-center gap-2">
            <span class="text-xs font-medium text-indigo-700 bg-indigo-50 px-2 py-0.5 rounded">
                {{ $post->category?->name ?? 'Sans catégorie' }}
            </span>
            @if (! $post->is_published)
                <span class="text-xs font-medium bg-gray-200 text-gray-700 px-2 py-0.5 rounded-full">Brouillon</span>
            @endif
        </div>

        <h1 class="text-3xl font-bold mt-2 mb-2">{{ $post->title }}</h1>

        <p class="text-sm text-gray-500 mb-4">
            @if ($post->user)
                Par {{ $post->user->name }} ·
            @endif
            @if ($post->published_at)
                Publié le {{ $post->published_at->format('d/m/Y') }}
            @else
                Brouillon
            @endif
        </p>

        @if ($post->tags->isNotEmpty())
            <div class="flex flex-wrap gap-1.5 mb-6">
                @foreach ($post->tags as $tag)
                    <span class="text-xs bg-gray-100 text-gray-700 px-2 py-0.5 rounded">{{ $tag->name }}</span>
                @endforeach
            </div>
        @endif

        <div class="text-gray-800 leading-relaxed whitespace-pre-line">{{ $post->body }}</div>

        <div class="mt-8 flex items-center gap-4 border-t border-gray-200 pt-4">
            <a href="{{ route('posts.edit', $post) }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">Modifier</a>

            <form method="POST" action="{{ route('posts.publication', $post) }}">
                @csrf
                @method('PATCH')
                <button type="submit" class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                    {{ $post->is_published ? 'Dépublier' : 'Publier' }}
                </button>
            </form>

            <form method="POST" action="{{ route('posts.destroy', $post) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="rounded-md border border-red-300 px-4 py-2 text-sm font-medium text-red-700 hover:bg-red-50">Supprimer</button>
            </form>
        </div>
    </article>
</x-layout>
