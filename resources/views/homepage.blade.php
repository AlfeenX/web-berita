<x-portal-layout>
    @if(request()->routeIs('home') && !request()->has('search') && !request()->has('category') && $featured->count() > 0)
        {{-- Hero Carousel (only on root homepage without filters) --}}
        @include('portal.hero-slider', ['articles' => $featured])
    @endif

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
        
        {{-- Filter/Search Indicator --}}
        @if(request('search') || request('category'))
            <div class="mb-8 flex items-center justify-between p-4 bg-indigo-50 dark:bg-indigo-900/20 rounded-xl border border-indigo-100 dark:border-indigo-800/50">
                <div>
                    <h1 class="text-indigo-900 dark:text-indigo-100 font-medium">
                        Menampilkan hasil untuk: 
                        @if(request('search'))
                            Pencarian "<span class="font-bold">{{ request('search') }}</span>"
                        @endif
                        @if(request('search') && request('category'))
                            dan 
                        @endif
                        @if(request('category'))
                            Kategori "<span class="font-bold">{{ request('category') }}</span>"
                        @endif
                    </h1>
                </div>
                <a href="{{ route('home') }}" class="text-indigo-600 dark:text-indigo-400 text-sm font-semibold hover:underline">Reset</a>
            </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-10">
            {{-- Main Content: Latest News --}}
            <div class="flex-1 lg:max-w-[calc(100%-380px)]">
                @include('portal.latest-section', ['articles' => $latest])
            </div>

            {{-- Sidebar --}}
            <aside class="w-full lg:w-[340px] shrink-0 space-y-10">
                {{-- Trending Section --}}
                @if($trending->count() > 0)
                    @include('portal.trending-section', ['articles' => $trending])
                @endif
                
                {{-- Categories Section --}}
                <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-zinc-100 dark:border-zinc-800/60 p-6 sticky top-[500px]">
                    <div class="flex items-center gap-2 mb-6 pb-4 border-b border-zinc-100 dark:border-zinc-800">
                        <div class="w-2 h-6 rounded-full bg-violet-500"></div>
                        <h3 class="text-xl font-extrabold text-zinc-900 dark:text-white">Topik Pilihan</h3>
                    </div>
                    
                    <div class="flex flex-wrap gap-2">
                        @foreach($categories as $category)
                            <a href="{{ route('home', ['category' => $category->slug]) }}" 
                               class="inline-flex items-center justify-between px-4 py-2 rounded-xl bg-zinc-50 dark:bg-zinc-800/50 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-indigo-50 hover:text-indigo-600 dark:hover:bg-indigo-900/30 dark:hover:text-indigo-400 transition-colors border border-zinc-200/60 dark:border-zinc-700/60 hover:border-indigo-200 dark:hover:border-indigo-800">
                                <span>{{ $category->name }}</span>
                                <span class="ml-2 w-6 h-6 rounded-full bg-white dark:bg-zinc-950 flex items-center justify-center text-[10px] text-zinc-500 border border-zinc-100 dark:border-zinc-800">{{ $category->articles_count }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>
    </div>
</x-portal-layout>