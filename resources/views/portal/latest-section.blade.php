@props(['articles'])

<div class="space-y-8">
    <div class="flex items-center justify-between border-b border-zinc-200 dark:border-zinc-800 pb-4">
        <div class="flex items-center gap-3">
            <div class="w-2 h-8 rounded-full bg-indigo-600"></div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-zinc-900 dark:text-white">Berita Terbaru</h2>
        </div>
        @if(request('category'))
            <a href="{{ route('home') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300">
                &larr; Lihat Semua
            </a>
        @endif
    </div>

    @if($articles->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
            @foreach($articles as $article)
                @include('portal.article-card', ['article' => $article])
            @endforeach
        </div>

        <div class="mt-12">
            {{ $articles->links() }}
        </div>
    @else
        <div class="text-center py-20 bg-zinc-50 dark:bg-zinc-900 rounded-2xl border border-dashed border-zinc-200 dark:border-zinc-800">
            <svg class="w-16 h-16 mx-auto text-zinc-400 dark:text-zinc-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5L16.5 5.5M9 11l3 3L22 4"/></svg>
            <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100">Belum ada berita</h3>
            <p class="text-zinc-500 mt-1">Coba sesuaikan pencarian atau kategori Anda.</p>
        </div>
    @endif
</div>
