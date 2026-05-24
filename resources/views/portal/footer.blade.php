{{-- Footer --}}
<footer class="bg-zinc-900 dark:bg-zinc-950 border-t border-zinc-800">
    {{-- Main footer --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

            {{-- About --}}
            <div class="lg:col-span-2">
                <div class="flex items-center gap-3 mb-4">
                    <img src="/images/logo-removed-bg.png" alt="PareDaily" class="h-10 w-auto brightness-110">
                </div>
                <p class="text-zinc-400 text-sm leading-relaxed max-w-md">
                    Portal berita lokal terpercaya yang menyajikan informasi terkini, akurat, dan berimbang seputar Kediri, Pare, dan sekitarnya. Menghadirkan jurnalisme berkualitas untuk masyarakat.
                </p>
                <div class="flex items-center gap-3 mt-6">
                    <a href="#" class="w-9 h-9 rounded-lg bg-zinc-800 hover:bg-indigo-600 flex items-center justify-center text-zinc-400 hover:text-white transition-all duration-200">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                    </a>
                    <a href="#" class="w-9 h-9 rounded-lg bg-zinc-800 hover:bg-indigo-600 flex items-center justify-center text-zinc-400 hover:text-white transition-all duration-200">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    </a>
                    <a href="#" class="w-9 h-9 rounded-lg bg-zinc-800 hover:bg-indigo-600 flex items-center justify-center text-zinc-400 hover:text-white transition-all duration-200">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                    </a>
                </div>
            </div>

            {{-- Quick Links --}}
            <div>
                <h4 class="text-white font-semibold text-sm mb-4 uppercase tracking-wider">Navigasi</h4>
                <ul class="space-y-2.5">
                    <li><a href="{{ route('home') }}" class="text-zinc-400 hover:text-indigo-400 text-sm transition-colors duration-200">Beranda</a></li>
                    <li><a href="#" class="text-zinc-400 hover:text-indigo-400 text-sm transition-colors duration-200">Tentang Kami</a></li>
                    <li><a href="#" class="text-zinc-400 hover:text-indigo-400 text-sm transition-colors duration-200">Kontak Redaksi</a></li>
                    <li><a href="#" class="text-zinc-400 hover:text-indigo-400 text-sm transition-colors duration-200">Pedoman Media</a></li>
                    <li><a href="#" class="text-zinc-400 hover:text-indigo-400 text-sm transition-colors duration-200">Kebijakan Privasi</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <h4 class="text-white font-semibold text-sm mb-4 uppercase tracking-wider">Kontak</h4>
                <ul class="space-y-2.5">
                    <li class="flex items-start gap-2.5 text-sm text-zinc-400">
                        <svg class="w-4 h-4 mt-0.5 shrink-0 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>Jl. Pahlawan No. 123, Pare, Kediri, Jawa Timur 64211</span>
                    </li>
                    <li class="flex items-center gap-2.5 text-sm text-zinc-400">
                        <svg class="w-4 h-4 shrink-0 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span>redaksi@paredaily.com</span>
                    </li>
                    <li class="flex items-center gap-2.5 text-sm text-zinc-400">
                        <svg class="w-4 h-4 shrink-0 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <span>(0354) 123-4567</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Bottom bar --}}
    <div class="border-t border-zinc-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col sm:flex-row items-center justify-between gap-2">
            <p class="text-zinc-500 text-xs">&copy; {{ date('Y') }} PareDaily. Seluruh hak cipta dilindungi.</p>
            <p class="text-zinc-600 text-xs">Dibuat dengan <span class="text-red-400">♥</span> di Pare, Kediri</p>
        </div>
    </div>
</footer>
