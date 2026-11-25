@props(['post'])

<article class="bg-white rounded-lg border border-gray-200 shadow-sm p-5 flex flex-col gap-3">
    <div class="flex items-center justify-between gap-2">
        <p class="text-xs text-gray-500">
            @if ($post->category)
                <a href="{{ route('posts.category', $post->category) }}" class="underline hover:text-indigo-600">{{ $post->category->name }}</a>
            @else
                Sans catégorie
            @endif
            - par {{ $post->user?->name ?? 'auteur inconnu' }}
        </p>
        @if (! $post->is_published)
            <span class="text-xs font-medium bg-gray-200 text-gray-700 px-2 py-0.5 rounded-full">Brouillon</span>
        @endif
    </div>

    <h2 class="text-lg font-semibold text-gray-900">
        <a href="{{ route('posts.show', $post) }}" class="hover:text-indigo-600">{{ $post->title }}</a>
    </h2>

    <p class="text-sm text-gray-600">{{ Str::limit($post->body, 120) }}</p>

    @if ($post->tags->isNotEmpty())
        <div class="flex flex-wrap gap-1.5">
            @foreach ($post->tags as $tag)
                <a href="{{ route('posts.tag', $tag) }}" class="text-xs bg-gray-100 text-gray-700 px-2 py-0.5 rounded hover:bg-indigo-50 hover:text-indigo-600">{{ $tag->name }}</a>
            @endforeach
        </div>
    @endif

    <p class="text-xs text-gray-500">
        @if ($post->published_at)
            Publié le {{ $post->published_at->format('d/m/Y') }} -
            <a href="{{ route('posts.archive', $post->published_at->year) }}" class="underline">Archive {{ $post->published_at->year }}</a>
        @else
            Non publié
        @endif
    </p>

    <a href="{{ route('posts.show', $post) }}" class="text-sm font-medium text-indigo-600 hover:underline">Lire l'article</a>
</article>
