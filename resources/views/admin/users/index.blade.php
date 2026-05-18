<x-layouts::app :title="__('Manage Pengguna')">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-zinc-900 dark:text-white">Manage Pengguna</h1>
            <p class="text-zinc-500 dark:text-zinc-400 mt-1">Buat, perbarui, dan hapus akun pengguna/penulis Anda secara langsung.</p>
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

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-10">
        {{-- Form Tambah Pengguna --}}
        <div class="mb-8">
            <flux:card class="p-6 shadow-md border-zinc-200/80 dark:border-zinc-700/80 bg-white/50 dark:bg-zinc-900/50 backdrop-blur-md">
                <form action="{{ route('users.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-2 gap-4 items-end">
                    <div class="flex items-center justify-between col-span-1 md:col-span-2">
                        <div class="mb-5">
                            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Tambah Pengguna Baru</h2>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400 max-w-sm">Buat akun baru untuk penulis agar dapat mulai mempublikasikan berita.</p>
                        </div>
                        <flux:button type="submit" variant="primary" icon="plus" class="h-10 bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-5 rounded-lg transition-all duration-200 transform hover:scale-[1.02] inline-block shrink-0">
                            Tambah
                        </flux:button>
                    </div>
                    @csrf
                    <flux:field>
                        <flux:label class="text-zinc-600 dark:text-zinc-300 font-medium">Nama Lengkap</flux:label>
                        <flux:input
                            name="name"
                            placeholder="Nama Lengkap..."
                            value="{{ old('name') }}"
                            required
                            class="w-full h-10 border-zinc-200 focus:border-indigo-500 dark:border-zinc-700 dark:bg-zinc-800"
                        />
                        <flux:error name="name" />
                    </flux:field>
                    <flux:field>
                        <flux:label class="text-zinc-600 dark:text-zinc-300 font-medium">Email</flux:label>
                        <flux:input
                            type="email"
                            name="email"
                            placeholder="email@example.com"
                            value="{{ old('email') }}"
                            required
                            class="w-full h-10 border-zinc-200 focus:border-indigo-500 dark:border-zinc-700 dark:bg-zinc-800"
                        />
                        <flux:error name="email" />
                    </flux:field>
                    <flux:field>
                        <flux:label class="text-zinc-600 dark:text-zinc-300 font-medium">Kata Sandi</flux:label>
                        <flux:input
                            type="password"
                            name="password"
                            placeholder="Minimal 8 karakter"
                            required
                            class="w-full h-10 border-zinc-200 focus:border-indigo-500 dark:border-zinc-700 dark:bg-zinc-800"
                        />
                        <flux:error name="password" />
                    </flux:field>
                    <div class="flex gap-2 items-end w-full">
                        <flux:field class="grow">
                            <flux:label class="text-zinc-600 dark:text-zinc-300 font-medium">Konfirmasi Sandi</flux:label>
                            <flux:input
                                type="password"
                                name="password_confirmation"
                                placeholder="Ketik ulang sandi"
                                required
                                class="w-full h-10 border-zinc-200 focus:border-indigo-500 dark:border-zinc-700 dark:bg-zinc-800"
                            />
                        </flux:field>
                    </div>
                </form>
            </flux:card>
        </div>
        {{-- Daftar Pengguna --}}
        <flux:card class="p-6 shadow-md border-zinc-200/80 dark:border-zinc-700/80 bg-white/50 dark:bg-zinc-900/50 backdrop-blur-md">
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Daftar Pengguna</h2>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Total: {{ $users->count() }} pengguna terdaftar</p>
            </div>
            @if ($users->isEmpty())
                <div class="flex flex-col items-center justify-center py-12 text-zinc-500 dark:text-zinc-400">
                    <flux:icon.users class="size-16 text-zinc-300 dark:text-zinc-600 mb-4 stroke-1" />
                    <p class="text-base font-medium">Belum ada pengguna</p>
                    <p class="text-sm text-zinc-400">Gunakan form di atas untuk membuat pengguna pertama Anda.</p>
                </div>
            @else
                <flux:table>
                    <flux:table.columns>
                        <flux:table.column class="w-16">No</flux:table.column>
                        <flux:table.column>Nama Lengkap</flux:table.column>
                        <flux:table.column>Email</flux:table.column>
                        <flux:table.column class="w-40 text-center">Jumlah Artikel</flux:table.column>
                        <flux:table.column align="end" class="w-32">Aksi</flux:table.column>
                    </flux:table.columns>
                    <flux:table.rows>
                        @foreach ($users as $index => $user)
                            <flux:table.row class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/30 transition-colors duration-150">
                                <flux:table.cell class="font-medium text-zinc-500 dark:text-zinc-400">
                                    {{ $index + 1 }}
                                </flux:table.cell>
                                
                                {{-- Nama Lengkap --}}
                                <flux:table.cell>
                                    <span class="font-semibold text-zinc-800 dark:text-zinc-200">{{ $user->name }}</span>
                                </flux:table.cell>
                                
                                {{-- Email --}}
                                <flux:table.cell>
                                    <span class="font-medium text-zinc-600 dark:text-zinc-400">{{ $user->email }}</span>
                                </flux:table.cell>
                                
                                {{-- Jumlah Artikel --}}
                                <flux:table.cell class="text-center">
                                    <span class="inline-flex items-center justify-center px-2.5 py-1 text-xs font-bold rounded-full {{ $user->articles_count > 0 ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400' : 'bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400' }}">
                                        {{ $user->articles_count }}
                                    </span>
                                </flux:table.cell>
                                
                                {{-- Aksi --}}
                                <flux:table.cell align="end">
                                    <div class="flex items-center justify-end gap-2">
                                        <flux:modal.trigger name="edit-user-{{ $user->id }}">
                                            <flux:button
                                                size="sm"
                                                icon="pencil-square"
                                                variant="ghost"
                                                class="hover:text-indigo-600 dark:hover:text-indigo-400"
                                                title="Edit Pengguna"
                                            />
                                        </flux:modal.trigger>
                                        
                                        <flux:modal.trigger name="delete-user-{{ $user->id }}">
                                            <flux:button
                                                size="sm"
                                                icon="trash"
                                                variant="ghost"
                                                class="hover:text-rose-600 dark:hover:text-rose-400"
                                                title="Hapus Pengguna"
                                            />
                                        </flux:modal.trigger>
                                    </div>
                                    
                                    {{-- Modal Edit --}}
                                    <flux:modal name="edit-user-{{ $user->id }}" class="max-w-md">
                                        <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-6">
                                            @csrf
                                            @method('PUT')
                                            
                                            <div>
                                                <flux:heading size="lg" align="start">Edit Akun Pengguna</flux:heading>
                                                <flux:subheading class="mt-2 text-zinc-500 dark:text-zinc-400">
                                                    Perbarui profil penulis atau ubah kata sandi mereka.
                                                </flux:subheading>
                                            </div>

                                            <flux:field>
                                                <flux:label>Nama Lengkap</flux:label>
                                                <flux:input name="name" value="{{ old('name', $user->name) }}" required class="h-10" />
                                                <flux:error name="name" />
                                            </flux:field>

                                            <flux:field>
                                                <flux:label>Email</flux:label>
                                                <flux:input type="email" name="email" value="{{ old('email', $user->email) }}" required class="h-10" />
                                                <flux:error name="email" />
                                            </flux:field>

                                            <flux:field>
                                                <flux:label>Kata Sandi Baru (Opsional)</flux:label>
                                                <flux:input type="password" name="password" placeholder="Kosongkan jika tidak diubah" class="h-10" />
                                                <flux:error name="password" />
                                            </flux:field>

                                            <flux:field>
                                                <flux:label>Konfirmasi Kata Sandi Baru</flux:label>
                                                <flux:input type="password" name="password_confirmation" placeholder="Konfirmasi kata sandi baru" class="h-10" />
                                            </flux:field>

                                            <div class="flex justify-end gap-2 mt-6">
                                                <flux:modal.close>
                                                    <flux:button variant="ghost">Batal</flux:button>
                                                </flux:modal.close>
                                                <flux:button variant="primary" type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white">Simpan Perubahan</flux:button>
                                            </div>
                                        </form>
                                    </flux:modal>
                                    
                                    {{-- Modal Hapus --}}
                                    <flux:modal name="delete-user-{{ $user->id }}" class="max-w-md">
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="space-y-6">
                                            @csrf
                                            @method('DELETE')
                                            <div>
                                                <flux:heading size="lg">Hapus Akun Pengguna</flux:heading>
                                                <flux:subheading class="mt-2 text-zinc-500 dark:text-zinc-400 leading-relaxed">
                                                    Apakah Anda yakin ingin menghapus pengguna <strong class="text-zinc-900 dark:text-white">"{{ $user->name }}"</strong>? Tindakan ini akan menghapus akun beserta seluruh data artikel yang ditulisnya secara permanen.
                                                </flux:subheading>
                                            </div>
                                            <div class="flex justify-end gap-2">
                                                <flux:modal.close>
                                                    <flux:button variant="ghost">Batal</flux:button>
                                                </flux:modal.close>
                                                <flux:button variant="danger" type="submit">Hapus Pengguna</flux:button>
                                            </div>
                                        </form>
                                    </flux:modal>
                                </flux:table.cell>
                            </flux:table.row>
                        @endforeach
                    </flux:table.rows>
                </flux:table>
            @endif
        </flux:card>
    </div>
</x-layouts::app>