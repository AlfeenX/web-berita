<x-layouts::app :title="__('Manage Artikel')">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-zinc-900 dark:text-white">Manage Artikel</h1>
            <p class="text-zinc-500 dark:text-zinc-400 mt-1">Membuat, memperbarui, dan menghapus artikel berita Anda secara dinamis.</p>
        </div>

        <flux:button href="{{ route('articles.create') }}" variant="primary" icon="plus" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium">
            Tambah Artikel
        </flux:button>
    </div>

    {{-- Alert Banner --}}
    <div class="space-y-4">
        @if (session('success'))
            <div class="flex items-center gap-3 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 dark:text-emerald-400 rounded-xl mb-6 shadow-sm animate-fade-in">
                <flux:icon.check-circle class="size-5" />
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="flex items-center gap-3 p-4 bg-rose-500/10 border border-rose-500/20 text-rose-600 dark:text-rose-400 rounded-xl mb-6 shadow-sm animate-fade-in">
                <flux:icon.exclamation-circle class="size-5" />
                <span class="text-sm font-medium">{{ session('error') }}</span>
            </div>
        @endif
    </div>

    <div class="mt-8 space-y-6">
        {{-- Pencarian & Filter --}}
        <flux:card class="p-4 shadow-sm border-zinc-200/80 dark:border-zinc-700/80 bg-white/50 dark:bg-zinc-900/50 backdrop-blur-md">
            <form x-ref="filterForm" action="{{ route('articles.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
                <flux:field class="grow w-full">
                    <flux:label class="text-xs font-semibold text-zinc-500">Pencarian</flux:label>
                    <flux:input 
                        name="search" 
                        value="{{ request('search') }}" 
                        icon="magnifying-glass" 
                        placeholder="Cari berdasarkan judul atau isi berita..." 
                        class="h-10 border-zinc-200 focus:border-indigo-500 dark:border-zinc-700 dark:bg-zinc-800"
                        x-data
                        x-init="if('{{ request('search') }}') {
                            const input = $el.querySelector('input');
                            if (input) {
                                input.focus();
                                input.setSelectionRange(input.value.length, input.value.length);
                            }
                        }"
                        @input.debounce.500ms="$refs.filterForm.submit()"
                    />
                </flux:field>

                <flux:field class="w-full md:w-64">
                    <flux:label class="text-xs font-semibold text-zinc-500">Kategori</flux:label>
                    <flux:select name="category" placeholder="Semua Kategori" class="h-10" @change="$refs.filterForm.submit()">
                        <flux:select.option value="">Semua Kategori</flux:select.option>
                        @foreach ($categories as $category)
                            <flux:select.option value="{{ $category->id }}" :selected="request('category') == $category->id">
                                {{ $category->name }}
                            </flux:select.option>
                        @endforeach
                    </flux:select>
                </flux:field>

                <div class="flex gap-2 w-full md:w-auto">
                    <flux:button type="submit" variant="primary" class="w-full md:w-auto h-10 bg-indigo-600 hover:bg-indigo-700 text-white px-5">
                        Filter
                    </flux:button>

                    @if (request()->filled('search') || request()->filled('category'))
                        <flux:button href="{{ route('articles.index') }}" variant="ghost" class="w-full md:w-auto h-10">
                            Reset
                        </flux:button>
                    @endif
                </div>
            </form>
        </flux:card>

        {{-- Tabel Artikel --}}
        <flux:card class="p-6 shadow-md border-zinc-200/80 dark:border-zinc-700/80 bg-white/50 dark:bg-zinc-900/50 backdrop-blur-md">
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Daftar Artikel</h2>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Total: {{ $articles->total() }} artikel terbit</p>
            </div>

            @if ($articles->isEmpty())
                <div class="flex flex-col items-center justify-center py-16 text-zinc-500 dark:text-zinc-400">
                    <flux:icon.document-text class="size-16 text-zinc-300 dark:text-zinc-600 mb-4 stroke-1" />
                    <p class="text-base font-semibold">Tidak ada artikel ditemukan</p>
                    <p class="text-sm text-zinc-400 mt-1">Coba sesuaikan filter pencarian atau buat artikel baru.</p>
                </div>
            @else
                <flux:table>
                    <flux:table.columns>
                        <flux:table.column class="w-16">No</flux:table.column>
                        <flux:table.column class="w-24">Thumbnail</flux:table.column>
                        <flux:table.column>Judul</flux:table.column>
                        <flux:table.column class="w-40">Kategori</flux:table.column>
                        <flux:table.column class="w-40">Penulis</flux:table.column>
                        <flux:table.column class="w-40">Tanggal Rilis</flux:table.column>
                        <flux:table.column align="end" class="w-28">Aksi</flux:table.column>
                    </flux:table.columns>

                    <flux:table.rows>
                        @foreach ($articles as $index => $article)
                            <flux:table.row class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/30 transition-colors duration-150">
                                <flux:table.cell class="font-medium text-zinc-500 dark:text-zinc-400">
                                    {{ $articles->firstItem() + $index }}
                                </flux:table.cell>

                                <flux:table.cell>
                                    @if ($article->image)
                                        <img src="{{ asset('storage/' . $article->image) }}" class="size-12 object-cover rounded-lg border border-zinc-200 dark:border-zinc-700 shadow-sm" alt="Thumbnail">
                                    @else
                                        <div class="size-12 rounded-lg bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center border border-zinc-200/50 dark:border-zinc-700/50 shadow-sm">
                                            <flux:icon.photo class="size-6 text-zinc-400 dark:text-zinc-500" />
                                        </div>
                                    @endif
                                </flux:table.cell>

                                <flux:table.cell>
                                    <div class="font-semibold text-zinc-900 dark:text-white leading-snug">
                                        {{ $article->title }}
                                    </div>
                                    <div class="text-xs text-zinc-400 font-mono mt-1">
                                        {{ $article->slug }}
                                    </div>
                                </flux:table.cell>

                                <flux:table.cell>
                                    <span class="inline-flex items-center px-2.5 py-1 text-xs font-bold rounded-full bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400">
                                        {{ $article->category->name }}
                                    </span>
                                </flux:table.cell>

                                <flux:table.cell class="text-zinc-700 dark:text-zinc-300 font-medium">
                                    {{ $article->user->name ?? 'Anonim' }}
                                </flux:table.cell>

                                <flux:table.cell class="text-zinc-500 dark:text-zinc-400 text-sm">
                                    {{ $article->created_at ? $article->created_at->format('d M Y') : '-' }}
                                </flux:table.cell>

                                <flux:table.cell align="end">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <flux:button 
                                            href="{{ route('articles.edit', $article) }}" 
                                            size="sm" 
                                            icon="pencil-square" 
                                            variant="ghost" 
                                            class="hover:text-indigo-600 dark:hover:text-indigo-400"
                                            title="Edit Artikel"
                                        />

                                        <flux:modal.trigger name="delete-article-{{ $article->id }}">
                                            <flux:button 
                                                size="sm" 
                                                icon="trash" 
                                                variant="ghost" 
                                                class="hover:text-rose-600 dark:hover:text-rose-400"
                                                title="Hapus Artikel"
                                            />
                                        </flux:modal.trigger>
                                    </div>

                                    {{-- Modal Hapus --}}
                                    <flux:modal name="delete-article-{{ $article->id }}" class="max-w-md">
                                        <form action="{{ route('articles.destroy', $article) }}" method="POST" class="space-y-6">
                                            @csrf
                                            @method('DELETE')
                                            <div>
                                                <flux:heading size="lg">Hapus Artikel</flux:heading>
                                                <flux:subheading class="mt-2 text-zinc-500 dark:text-zinc-400 leading-relaxed">
                                                    Apakah Anda yakin ingin menghapus artikel <strong class="text-zinc-900 dark:text-white">"{{ $article->title }}"</strong>? Tindakan ini akan menghapus seluruh data dan media artikel secara permanen.
                                                </flux:subheading>
                                            </div>

                                            <div class="flex justify-end gap-2">
                                                <flux:modal.close>
                                                    <flux:button variant="ghost">Batal</flux:button>
                                                </flux:modal.close>
                                                <flux:button variant="danger" type="submit">Hapus Artikel</flux:button>
                                            </div>
                                        </form>
                                    </flux:modal>
                                </flux:table.cell>
                            </flux:table.row>
                        @endforeach
                    </flux:table.rows>
                </flux:table>
                <div class="mt-6">
                    {{ $articles->links() }}
                </div>
            @endif
        </flux:card>
    </div>
</x-layouts::app>