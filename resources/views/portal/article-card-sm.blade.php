@props(['article', 'loop'])

<div class="group flex gap-4 items-start">
    <a href="{{ route('articles.detail', $article->slug) }}" class="block shrink-0 w-24 h-24 sm:w-28 sm:h-28 rounded-xl overflow-hidden bg-zinc-100 dark:bg-zinc-800 relative">
        @if($article->image)
            <img src="{{ Storage::url($article->image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
        @else
            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br {{ $loop->iteration % 3 == 0 ? 'from-emerald-100 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/10' : 'from-indigo-100 to-violet-50 dark:from-indigo-900/20 dark:to-violet-900/10' }}">
                <span class="text-zinc-300 dark:text-zinc-700">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </span>
            </div>
        @endif
    </a>
    
    <div class="flex-1 py-1">
        <div class="mb-1.5">
            @include('portal.category-badge', ['category' => $article->category])
        </div>
        <h4 class="font-serif text-sm sm:text-base font-bold text-zinc-900 dark:text-white leading-snug mb-2 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
            <a href="{{ route('articles.detail', $article->slug) }}" class="line-clamp-2">
                {{ $article->title }}
            </a>
        </h4>
        <div class="flex items-center gap-2 text-[10px] text-zinc-500 dark:text-zinc-400 font-medium uppercase tracking-wider">
            <span>{{ $article->user->name }}</span>
            <span class="w-1 h-1 rounded-full bg-zinc-300 dark:bg-zinc-700"></span>
            <span>{{ $article->published_at->locale('id')->isoFormat('D MMM Y') }}</span>
        </div>
    </div>
</div>
