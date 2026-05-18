<x-layouts::app :title="__('Dashboard')">
    <div class="space-y-8 animate-fade-in">
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight text-zinc-900 dark:text-white">
                    Selamat Datang, {{ auth()->user()->name }}! 👋
                </h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1.5">
                    Berikut adalah ringkasan performa dan aktivitas portal berita Anda saat ini.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <flux:button href="{{ route('articles.create') }}" variant="primary" icon="plus" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium shadow-sm transition-all duration-200">
                    Tulis Artikel Baru
                </flux:button>
            </div>
        </div>

        {{-- Dynamic Stats Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Card 1: Articles --}}
            <div class="relative overflow-hidden rounded-2xl border border-indigo-500/10 dark:border-indigo-500/20 bg-gradient-to-br from-indigo-500/[0.07] to-purple-500/[0.02] dark:from-indigo-950/20 dark:to-purple-950/10 p-6 backdrop-blur-md transition-all duration-300 hover:shadow-lg hover:shadow-indigo-500/5 group">
                <div class="absolute -right-6 -bottom-6 text-indigo-500/10 dark:text-indigo-400/5 group-hover:scale-110 transition-transform duration-300 ease-out">
                    <flux:icon.document-text class="size-32 stroke-1" />
                </div>
                <div class="flex items-center gap-4">
                    <div class="flex items-center justify-center p-3 rounded-xl bg-indigo-500/10 dark:bg-indigo-400/10 text-indigo-600 dark:text-indigo-400 ring-4 ring-indigo-500/5">
                        <flux:icon.document-text class="size-6" />
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-indigo-600/90 dark:text-indigo-400/90 tracking-wide uppercase">Total Artikel</p>
                        <h2 class="text-3xl font-extrabold text-zinc-900 dark:text-white mt-1">{{ number_format($totalArticles) }}</h2>
                    </div>
                </div>
                <div class="mt-5 pt-4 border-t border-indigo-500/10 dark:border-indigo-400/10 flex items-center justify-between">
                    <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Minggu ini</span>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs font-bold rounded-full bg-indigo-500/10 text-indigo-700 dark:bg-indigo-400/10 dark:text-indigo-400">
                        +{{ $articlesThisWeek }} baru
                    </span>
                </div>
            </div>

            {{-- Card 2: Categories --}}
            <div class="relative overflow-hidden rounded-2xl border border-emerald-500/10 dark:border-emerald-500/20 bg-gradient-to-br from-emerald-500/[0.07] to-teal-500/[0.02] dark:from-emerald-950/20 dark:to-teal-950/10 p-6 backdrop-blur-md transition-all duration-300 hover:shadow-lg hover:shadow-emerald-500/5 group">
                <div class="absolute -right-6 -bottom-6 text-emerald-500/10 dark:text-emerald-400/5 group-hover:scale-110 transition-transform duration-300 ease-out">
                    <flux:icon.folder class="size-32 stroke-1" />
                </div>
                <div class="flex items-center gap-4">
                    <div class="flex items-center justify-center p-3 rounded-xl bg-emerald-500/10 dark:bg-emerald-400/10 text-emerald-600 dark:text-emerald-400 ring-4 ring-emerald-500/5">
                        <flux:icon.folder class="size-6" />
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-emerald-600/90 dark:text-emerald-400/90 tracking-wide uppercase">Kategori Berita</p>
                        <h2 class="text-3xl font-extrabold text-zinc-900 dark:text-white mt-1">{{ number_format($totalCategories) }}</h2>
                    </div>
                </div>
                <div class="mt-5 pt-4 border-t border-emerald-500/10 dark:border-emerald-400/10 flex items-center justify-between">
                    <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Status Kategori</span>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs font-bold rounded-full bg-emerald-500/10 text-emerald-700 dark:bg-emerald-400/10 dark:text-emerald-400">
                        Aktif
                    </span>
                </div>
            </div>

            {{-- Card 3: Users --}}
            <div class="relative overflow-hidden rounded-2xl border border-rose-500/10 dark:border-rose-500/20 bg-gradient-to-br from-rose-500/[0.07] to-pink-500/[0.02] dark:from-rose-950/20 dark:to-pink-950/10 p-6 backdrop-blur-md transition-all duration-300 hover:shadow-lg hover:shadow-rose-500/5 group">
                <div class="absolute -right-6 -bottom-6 text-rose-500/10 dark:text-rose-400/5 group-hover:scale-110 transition-transform duration-300 ease-out">
                    <flux:icon.user-group class="size-32 stroke-1" />
                </div>
                <div class="flex items-center gap-4">
                    <div class="flex items-center justify-center p-3 rounded-xl bg-rose-500/10 dark:bg-rose-400/10 text-rose-600 dark:text-rose-400 ring-4 ring-rose-500/5">
                        <flux:icon.user-group class="size-6" />
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-rose-600/90 dark:text-rose-400/90 tracking-wide uppercase">Penulis & Admin</p>
                        <h2 class="text-3xl font-extrabold text-zinc-900 dark:text-white mt-1">{{ number_format($totalUsers) }}</h2>
                    </div>
                </div>
                <div class="mt-5 pt-4 border-t border-rose-500/10 dark:border-rose-400/10 flex items-center justify-between">
                    <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Penulis terdaftar</span>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs font-bold rounded-full bg-rose-500/10 text-rose-700 dark:bg-rose-400/10 dark:text-rose-400">
                        +{{ $usersThisWeek }} baru
                    </span>
                </div>
            </div>
        </div>

        {{-- Main Activity Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Left column: Recent Articles --}}
            <div class="lg:col-span-2 space-y-6">
                <flux:card class="p-6 shadow-md border-zinc-200/80 dark:border-zinc-700/80 bg-white/60 dark:bg-zinc-900/60 backdrop-blur-md h-full">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-lg font-bold text-zinc-900 dark:text-white">Artikel Terbaru</h2>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">Daftar berita yang dipublikasikan baru-baru ini.</p>
                        </div>
                        <flux:button href="{{ route('articles.index') }}" variant="ghost" size="sm" class="text-xs text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-950/50">
                            Lihat Semua
                        </flux:button>
                    </div>

                    @if ($recentArticles->isEmpty())
                        <div class="flex flex-col items-center justify-center py-16 text-zinc-500 dark:text-zinc-400">
                            <div class="p-4 rounded-full bg-zinc-100 dark:bg-zinc-800 text-zinc-300 dark:text-zinc-600 mb-4">
                                <flux:icon.document-text class="size-12 stroke-1" />
                            </div>
                            <p class="text-sm font-semibold">Belum ada artikel</p>
                            <p class="text-xs text-zinc-400 mt-1">Mulai tulis artikel pertama Anda untuk mengisi dashboard ini.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <flux:table>
                                <flux:table.columns>
                                    <flux:table.column>Judul Berita</flux:table.column>
                                    <flux:table.column>Kategori</flux:table.column>
                                    <flux:table.column>Penulis</flux:table.column>
                                    <flux:table.column>Tanggal</flux:table.column>
                                    <flux:table.column align="end" class="w-16">Aksi</flux:table.column>
                                </flux:table.columns>
                                <flux:table.rows>
                                    @foreach ($recentArticles as $article)
                                        <flux:table.row class="hover:bg-zinc-50/40 dark:hover:bg-zinc-800/25 transition-colors duration-150">
                                            <flux:table.cell>
                                                <div class="flex items-center gap-3">
                                                    @if($article->image)
                                                        <img src="{{ asset('storage/' . $article->image) }}" alt="Preview" class="w-10 h-10 object-cover rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-100 dark:bg-zinc-800 shadow-sm shrink-0">
                                                    @else
                                                        <div class="w-10 h-10 rounded-lg bg-indigo-500/10 dark:bg-indigo-400/10 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0 border border-indigo-500/5">
                                                            <flux:icon.document-text class="size-5" />
                                                        </div>
                                                    @endif
                                                    <div class="min-w-0">
                                                        <span class="font-bold text-zinc-800 dark:text-zinc-200 block truncate max-w-[200px] md:max-w-[280px]" title="{{ $article->title }}">
                                                            {{ $article->title }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </flux:table.cell>
                                            <flux:table.cell>
                                                <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-semibold rounded-full bg-indigo-50/80 text-indigo-700 border border-indigo-100 dark:bg-indigo-950/40 dark:text-indigo-300 dark:border-indigo-900/30">
                                                    {{ $article->category->name }}
                                                </span>
                                            </flux:table.cell>
                                            <flux:table.cell>
                                                <span class="text-xs font-semibold text-zinc-700 dark:text-zinc-300">{{ $article->user->name }}</span>
                                            </flux:table.cell>
                                            <flux:table.cell class="whitespace-nowrap">
                                                <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400" title="{{ $article->created_at->format('d M Y H:i') }}">
                                                    {{ $article->created_at->diffForHumans() }}
                                                </span>
                                            </flux:table.cell>
                                            <flux:table.cell align="end">
                                                <flux:button href="{{ route('articles.edit', $article) }}" size="sm" icon="pencil-square" variant="ghost" class="hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-zinc-100 dark:hover:bg-zinc-800" title="Edit Artikel" />
                                            </flux:table.cell>
                                        </flux:table.row>
                                    @endforeach
                                </flux:table.rows>
                            </flux:table>
                        </div>
                    @endif
                </flux:card>
            </div>

            {{-- Right column: Popular Categories & Recent Users --}}
            <div class="space-y-6">
                {{-- Category Breakdown Card --}}
                <flux:card class="p-6 shadow-md border-zinc-200/80 dark:border-zinc-700/80 bg-white/60 dark:bg-zinc-900/60 backdrop-blur-md">
                    <div>
                        <h2 class="text-lg font-bold text-zinc-900 dark:text-white">Top Kategori</h2>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">Distribusi artikel berdasarkan kategori terpopuler.</p>
                    </div>

                    <div class="mt-6 space-y-4">
                        @if ($categoryBreakdown->isEmpty())
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 text-center py-6">Belum ada data kategori.</p>
                        @else
                            @foreach ($categoryBreakdown as $category)
                                @php
                                    $percentage = $totalArticles > 0 ? round(($category->articles_count / $totalArticles) * 100) : 0;
                                @endphp
                                <div class="space-y-1.5">
                                    <div class="flex items-center justify-between text-xs font-bold">
                                        <span class="text-zinc-700 dark:text-zinc-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">{{ $category->name }}</span>
                                        <span class="text-zinc-500 dark:text-zinc-400">{{ $category->articles_count }} artikel ({{ $percentage }}%)</span>
                                    </div>
                                    <div class="w-full bg-zinc-100 dark:bg-zinc-800 h-2 rounded-full overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-indigo-500 to-violet-600 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </flux:card>

                {{-- Recent Users Card --}}
                <flux:card class="p-6 shadow-md border-zinc-200/80 dark:border-zinc-700/80 bg-white/60 dark:bg-zinc-900/60 backdrop-blur-md">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="text-lg font-bold text-zinc-900 dark:text-white">Penulis Baru</h2>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">Penulis yang baru saja bergabung.</p>
                        </div>
                        <flux:button href="{{ route('users.index') }}" variant="ghost" size="sm" class="text-xs text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-950/50">
                            Kelola
                        </flux:button>
                    </div>

                    <div class="divide-y divide-zinc-100 dark:divide-zinc-800/80">
                        @if ($recentUsers->isEmpty())
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 text-center py-6">Belum ada penulis terdaftar.</p>
                        @else
                            @foreach ($recentUsers as $index => $user)
                                @php
                                    // Generate a stable color based on index to keep avatar badges beautifully varied
                                    $colors = [
                                        'bg-indigo-500/10 text-indigo-700 dark:bg-indigo-400/10 dark:text-indigo-300 border-indigo-200/30',
                                        'bg-emerald-500/10 text-emerald-700 dark:bg-emerald-400/10 dark:text-emerald-300 border-emerald-200/30',
                                        'bg-rose-500/10 text-rose-700 dark:bg-rose-400/10 dark:text-rose-300 border-rose-200/30',
                                        'bg-amber-500/10 text-amber-700 dark:bg-amber-400/10 dark:text-amber-300 border-amber-200/30',
                                        'bg-sky-500/10 text-sky-700 dark:bg-sky-400/10 dark:text-sky-300 border-sky-200/30',
                                    ];
                                    $colorClass = $colors[$index % count($colors)];
                                @endphp
                                <div class="flex items-center gap-3 py-3 first:pt-0 last:pb-0">
                                    <div class="w-9 h-9 rounded-full flex items-center justify-center text-xs font-bold border {{ $colorClass }} shrink-0">
                                        {{ $user->initials() }}
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-xs font-bold text-zinc-800 dark:text-zinc-200 truncate">{{ $user->name }}</p>
                                        <p class="text-[10px] text-zinc-500 dark:text-zinc-400 truncate">{{ $user->email }}</p>
                                    </div>
                                    <span class="text-[10px] text-zinc-400 dark:text-zinc-500 shrink-0 font-medium">
                                        {{ $user->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </flux:card>
            </div>
        </div>
    </div>
</x-layouts::app>
