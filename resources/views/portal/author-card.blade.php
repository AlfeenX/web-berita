@props(['user', 'articleCount' => 0])

<div class="bg-zinc-50 dark:bg-zinc-900/50 rounded-2xl border border-zinc-100 dark:border-zinc-800/80 p-6 sm:p-8 flex flex-col sm:flex-row gap-6 items-start">
    <div class="shrink-0 w-20 h-20 sm:w-24 sm:h-24 rounded-full overflow-hidden border-4 border-white dark:border-zinc-800 shadow-md">
        @if($user->profile?->avatar)
            <img src="{{ Storage::url($user->profile->avatar) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
        @else
            <div class="w-full h-full bg-indigo-100 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-bold text-2xl sm:text-3xl">
                {{ $user->initials() }}
            </div>
        @endif
    </div>
    
    <div class="flex-1">
        <h3 class="text-xs font-bold uppercase tracking-wider text-zinc-500 dark:text-zinc-400 mb-1">Ditulis Oleh</h3>
        <div class="flex items-center gap-3 mb-3">
            <h4 class="text-xl font-bold text-zinc-900 dark:text-white">{{ $user->name }}</h4>
            <span class="px-2.5 py-0.5 rounded-full bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 text-xs font-semibold">
                {{ $articleCount }} Artikel
            </span>
        </div>
        <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-1.5">{{ $user->profile?->phone ?? '' }}</p>
        
        <p class="text-zinc-600 dark:text-zinc-400 text-sm leading-relaxed mb-4">
            {{ $user->profile?->bio ?? 'Penulis di PareDaily.' }}
        </p>
        
        <a href="{{ route('home', ['search' => $user->name]) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors">
            Lihat semua artikel dari penulis ini
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
    </div>
</div>
