<x-layouts::app :title="__('Manage Tags')">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-zinc-900 dark:text-white">Manage Tags</h1>
            <p class="text-zinc-500 dark:text-zinc-400 mt-1">Buat, perbarui, dan hapus tags artikel Anda secara langsung.</p>
        </div>
    </div>

    {{-- Alert Banner --}}
    <div class="space-y-4">
        @if (session('success'))
            <div class="flex items-center gap-3 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 dark:text-emerald-400 rounded-xl mb-6 shadow-sm">
                <flux:icon.check-circle class="size-5" />
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="flex items-center gap-3 p-4 bg-rose-500/10 border border-rose-500/20 text-rose-600 dark:text-rose-400 rounded-xl mb-6 shadow-sm">
                <flux:icon.exclamation-circle class="size-5" />
                <span class="text-sm font-medium">{{ session('error') }}</span>
            </div>
        @endif
    </div>

    {{-- Form Tambah Kategori --}}
    <div class="mb-8">
        <flux:card class="p-6 shadow-md border-zinc-200/80 dark:border-zinc-700/80 bg-white/50 dark:bg-zinc-900/50 backdrop-blur-md">
            <div class="mb-5">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Tambah Tag Baru</h2>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Tag baru akan langsung dapat digunakan oleh penulis untuk artikel mereka.</p>
            </div>

            <form action="{{ route('tags.store') }}" method="POST" class="flex flex-col sm:flex-row gap-4 items-end max-w-3xl">
                @csrf
                <flux:field class="grow w-full">
                    <flux:label class="text-zinc-600 dark:text-zinc-300 font-medium">Nama Tag</flux:label>
                    <flux:input 
                        name="name" 
                        placeholder="Contoh: Teknologi, Sains, Gaya Hidup..." 
                        value="{{ old('name') }}" 
                        required 
                        class="w-full h-10 border-zinc-200 focus:border-indigo-500 dark:border-zinc-700 dark:bg-zinc-800"
                    />
                    <flux:error name="name" />
                </flux:field>

                <flux:button type="submit" variant="primary" icon="plus" class="w-full sm:w-auto h-10 bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-6 rounded-lg transition-all duration-200 transform hover:scale-[1.02] inline-block">
                    Tambah Tag
                </flux:button>
            </form>
        </flux:card>
    </div>

    {{-- Daftar tag --}}
    <flux:card class="p-6 shadow-md border-zinc-200/80 dark:border-zinc-700/80 bg-white/50 dark:bg-zinc-900/50 backdrop-blur-md">
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Daftar Tag</h2>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Total: {{ $tags->total() }} Tag terdaftar</p>
        </div>

        @if ($tags->isEmpty())
            <div class="flex flex-col items-center justify-center py-12 text-zinc-500 dark:text-zinc-400">
                <flux:icon.folder class="size-16 text-zinc-300 dark:text-zinc-600 mb-4 stroke-1" />
                <p class="text-base font-medium">Belum ada tag</p>
                <p class="text-sm text-zinc-400">Gunakan form di atas untuk membuat tag pertama Anda.</p>
            </div>
        @else
            <flux:table>
                <flux:table.columns>
                    <flux:table.column class="w-16">No</flux:table.column>
                    <flux:table.column>Nama Tag</flux:table.column>
                    <flux:table.column>Slug</flux:table.column>
                    <flux:table.column class="w-40 text-center">Jumlah Artikel</flux:table.column>
                    <flux:table.column align="end" class="w-32">Aksi</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @foreach ($tags as $index => $tag)
                        <flux:table.row x-data="{ editing: false, name: '{{ addslashes($tag->name) }}' }" class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/30 transition-colors duration-150">
                            <flux:table.cell class="font-medium text-zinc-500 dark:text-zinc-400">
                                {{ $tags->firstItem() + $index }}
                            </flux:table.cell>

                            <flux:table.cell>
                                <template x-if="!editing">
                                    <span class="font-semibold text-zinc-800 dark:text-zinc-200">{{ $tag->name }}</span>
                                </template>
                                <template x-if="editing">
                                    <form id="edit-form-{{ $tag->id }}" action="{{ route('tags.update', $tag) }}" method="POST" class="flex gap-2 items-center w-full max-w-md">
                                        @csrf
                                        @method('PUT')
                                        <flux:input name="name" x-model="name" size="sm" class="grow" required />
                                    </form>
                                </template>
                            </flux:table.cell>

                            <flux:table.cell>
                                <span class="font-mono text-xs text-zinc-500 dark:text-zinc-400 bg-zinc-100 dark:bg-zinc-800 px-2 py-1 rounded">
                                    {{ $tag->slug }}
                                </span>
                            </flux:table.cell>

                            <flux:table.cell class="text-center">
                                <span class="inline-flex items-center justify-center px-2.5 py-1 text-xs font-bold rounded-full {{ $tag->articles()->count() > 0 ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400' : 'bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400' }}">
                                    {{ $tag->articles()->count() }}
                                </span>
                            </flux:table.cell>

                            <flux:table.cell align="end">
                                <div class="flex items-center justify-end gap-2">
                                    <template x-if="!editing">
                                        <div class="flex gap-1.5">
                                            <flux:button 
                                                size="sm" 
                                                icon="pencil-square" 
                                                variant="ghost" 
                                                class="hover:text-indigo-600 dark:hover:text-indigo-400"
                                                @click="editing = true; $nextTick(() => $el.closest('tr').querySelector('input').focus())"
                                                title="Edit Tag"
                                            />

                                            <flux:modal.trigger name="delete-tag-{{ $tag->id }}">
                                                <flux:button 
                                                    size="sm" 
                                                    icon="trash" 
                                                    variant="ghost" 
                                                    class="hover:text-rose-600 dark:hover:text-rose-400"
                                                    title="Hapus Tag"
                                                />
                                            </flux:modal.trigger>
                                        </div>
                                    </template>
                                    <template x-if="editing">
                                        <div class="flex gap-1.5">
                                            <flux:button 
                                                size="sm" 
                                                type="submit" 
                                                form="edit-form-{{ $tag->id }}" 
                                                variant="primary" 
                                                class="bg-indigo-600 hover:bg-indigo-700 text-white"
                                            >
                                                Simpan
                                            </flux:button>
                                            <flux:button 
                                                size="sm" 
                                                variant="ghost" 
                                                @click="editing = false; name = '{{ addslashes($tag->name) }}'"
                                            >
                                                Batal
                                            </flux:button>
                                        </div>
                                    </template>
                                </div>

                                {{-- Modal Hapus --}}
                                <flux:modal name="delete-tag-{{ $tag->id }}" class="max-w-md">
                                    <form action="{{ route('tags.destroy', $tag) }}" method="POST" class="space-y-6">
                                        @csrf
                                        @method('DELETE')
                                        <div>
                                            <flux:heading size="lg">Hapus Tag</flux:heading>
                                            <flux:subheading class="mt-2 text-zinc-500 dark:text-zinc-400 leading-relaxed">
                                                Apakah Anda yakin ingin menghapus tag <strong class="text-zinc-900 dark:text-white">"{{ $tag->name }}"</strong>? Tindakan ini akan menghapus tag secara permanen dari sistem.
                                            </flux:subheading>
                                        </div>

                                        <div class="flex justify-end gap-2">
                                            <flux:modal.close>
                                                <flux:button variant="ghost">Batal</flux:button>
                                            </flux:modal.close>
                                            <flux:button variant="danger" type="submit">Hapus Tag</flux:button>
                                        </div>
                                    </form>
                                </flux:modal>
                            </flux:table.cell>
                        </flux:table.row>
                    @endforeach
                </flux:table.rows>
            </flux:table>
            <div class="mt-6">
                {{ $tags->links() }}
            </div>
        @endif
    </flux:card>
</x-layouts::app>