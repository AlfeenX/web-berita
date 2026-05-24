@props(['articles', 'title' => 'Sedang Populer'])

<div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-zinc-100 dark:border-zinc-800/60 p-6 sticky top-24">
    <div class="flex items-center gap-2 mb-6 pb-4 border-b border-zinc-100 dark:border-zinc-800">
        <div class="w-2 h-6 rounded-full bg-rose-500"></div>
        <h3 class="text-xl font-extrabold text-zinc-900 dark:text-white">{{ $title }}</h3>
    </div>
    
    <div class="space-y-6">
        @foreach($articles as $article)
            <div class="flex items-start gap-4 group">
                <div class="text-4xl font-black text-zinc-200 dark:text-zinc-800/80 group-hover:text-rose-500/20 transition-colors leading-none shrink-0 w-8">
                    {{ $loop->iteration }}
                </div>
                <div>
                    <div class="mb-1.5 flex items-center gap-2">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">{{ $article->category->name }}</span>
                        <span class="w-1 h-1 rounded-full bg-zinc-300 dark:bg-zinc-700"></span>
                        <span class="text-[10px] text-zinc-500 dark:text-zinc-400">{{ $article->reading_time }} mnt baca</span>
                    </div>
                    <h4 class="font-serif font-bold text-zinc-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors leading-snug">
                        <a href="{{ route('articles.detail', $article->slug) }}" class="line-clamp-2">
                            {{ $article->title }}
                        </a>
                    </h4>
                </div>
            </div>
        @endforeach
    </div>
</div>
