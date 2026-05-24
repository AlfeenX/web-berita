@props(['article', 'loop'])

<div class="group relative bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-zinc-100 dark:border-zinc-800/60 overflow-hidden hover:shadow-xl hover:border-zinc-200 dark:hover:border-zinc-700 transition-all duration-300 transform hover:-translate-y-1">
    <div class="block aspect-[16/10] overflow-hidden bg-zinc-100 dark:bg-zinc-800 relative">
        <a href="{{ route('articles.detail', $article->slug) }}" class="absolute inset-0 z-0">
            @if($article->image)
                <img src="{{ Storage::url($article->image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
            @else
                {{-- Image Placeholder with gradients --}}
                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br {{ $loop->iteration % 2 == 0 ? 'from-indigo-100 to-violet-50 dark:from-indigo-900/20 dark:to-violet-900/10' : 'from-rose-100 to-orange-50 dark:from-rose-900/20 dark:to-orange-900/10' }}">
                    <span class="text-zinc-300 dark:text-zinc-700">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </span>
                </div>
            @endif
        </a>
        
        <div class="absolute top-4 left-4 z-10">
            @include('portal.category-badge', ['category' => $article->category])
        </div>
    </div>

    <div class="p-5">
        <div class="flex items-center gap-3 text-[11px] text-zinc-500 dark:text-zinc-400 mb-3 font-medium uppercase tracking-wider">
            <span class="flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                {{ $article->user->name }}
            </span>
            <span class="w-1 h-1 rounded-full bg-zinc-300 dark:bg-zinc-700"></span>
            <span>{{ $article->published_at->locale('id')->diffForHumans() }}</span>
        </div>
        
        <h3 class="font-serif text-lg font-bold text-zinc-900 dark:text-white leading-snug mb-2 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
            <a href="{{ route('articles.detail', $article->slug) }}" class="line-clamp-2">
                {{ $article->title }}
            </a>
        </h3>
        
        <p class="text-sm text-zinc-600 dark:text-zinc-400 line-clamp-2 leading-relaxed">
            {{ $article->excerpt }}
        </p>
    </div>
</div>
