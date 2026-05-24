<x-portal-layout :title="$article->title" :meta-description="$article->excerpt">
    <article class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
        <div class="flex flex-col lg:flex-row gap-12 lg:gap-16">
            
            {{-- Main Content --}}
            <div class="flex-1 lg:max-w-[calc(100%-380px)]">
                
                {{-- Breadcrumbs & Meta --}}
                <div class="mb-8">
                    <nav class="flex text-sm text-zinc-500 mb-6 font-medium">
                        <a href="{{ route('home') }}" class="hover:text-indigo-600 transition-colors">Beranda</a>
                        <span class="mx-2">/</span>
                        <a href="{{ route('home', ['category' => $article->category->slug]) }}" class="hover:text-indigo-600 transition-colors">{{ $article->category->name }}</a>
                        <span class="mx-2">/</span>
                        <span class="text-zinc-400 line-clamp-1">{{ $article->title }}</span>
                    </nav>

                    <div class="mb-5">
                        @include('portal.category-badge', ['category' => $article->category])
                    </div>

                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-serif font-black text-zinc-900 dark:text-white leading-[1.15] tracking-tight mb-6">
                        {{ $article->title }}
                    </h1>

                    <div class="flex flex-wrap items-center gap-4 sm:gap-6 text-sm text-zinc-600 dark:text-zinc-400 py-4 border-y border-zinc-100 dark:border-zinc-800">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-zinc-200 dark:bg-zinc-800 flex items-center justify-center overflow-hidden">
                                @if($article->user->profile?->avatar)
                                    <img src="{{ Storage::url($article->user->profile->avatar) }}" alt="" class="w-full h-full object-cover">
                                @else
                                    <span class="text-xs font-bold text-zinc-500">{{ $article->user->initials() }}</span>
                                @endif
                            </div>
                            <div>
                                <p class="font-bold text-zinc-900 dark:text-zinc-200">{{ $article->user->name }}</p>
                                <p class="text-[11px] uppercase tracking-wider text-zinc-500">{{ $article->user->profile?->bio ? 'Jurnalis' : 'Penulis' }}</p>
                            </div>
                        </div>
                        
                        <div class="h-8 w-px bg-zinc-200 dark:bg-zinc-800 hidden sm:block"></div>
                        
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>{{ $article->published_at->locale('id')->isoFormat('dddd, D MMMM Y - HH:mm') }} WIB</span>
                        </div>
                        
                        <div class="h-8 w-px bg-zinc-200 dark:bg-zinc-800 hidden md:block"></div>
                        
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>{{ $article->reading_time }} mnt baca</span>
                        </div>
                    </div>
                </div>

                {{-- Featured Image --}}
                <div class="mb-10 rounded-2xl overflow-hidden bg-zinc-100 dark:bg-zinc-900">
                    @if($article->image)
                        <img src="{{ Storage::url($article->image) }}" alt="{{ $article->title }}" class="w-full h-auto max-h-[600px] object-cover">
                    @else
                        <div class="w-full aspect-[16/9] flex items-center justify-center bg-gradient-to-br from-indigo-100 to-violet-50 dark:from-indigo-900/20 dark:to-violet-900/10">
                            <svg class="w-20 h-20 text-indigo-300 dark:text-indigo-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    @endif
                </div>

                {{-- Content --}}
                <div class="prose prose-lg dark:prose-invert prose-indigo max-w-none mb-12 prose-p:leading-relaxed prose-headings:font-serif prose-a:text-indigo-600 dark:prose-a:text-indigo-400 hover:prose-a:text-indigo-500">
                    {!! nl2br(e($article->content)) !!}
                </div>

                {{-- Tags --}}
                @if($article->tags->count() > 0)
                    <div class="mb-12 pt-6 border-t border-zinc-100 dark:border-zinc-800 flex items-center gap-3 flex-wrap">
                        <span class="text-sm font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Tags:</span>
                        @foreach($article->tags as $tag)
                            <span class="px-3 py-1 rounded-lg bg-zinc-100 dark:bg-zinc-800 text-sm text-zinc-600 dark:text-zinc-300">
                                #{{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                @endif

                {{-- Author Profile --}}
                <div class="mb-12">
                    @include('portal.author-card', ['user' => $article->user, 'articleCount' => $authorArticleCount])
                </div>

            </div>

            {{-- Sidebar --}}
            <aside class="w-full lg:w-[340px] shrink-0 space-y-10">
                
                {{-- Share Component (Sticky) --}}
                <div class="bg-indigo-600 text-white rounded-2xl p-6 shadow-xl shadow-indigo-600/20 sticky top-24">
                    <h3 class="text-lg font-bold mb-4">Bagikan Berita</h3>
                    <p class="text-indigo-100 text-sm mb-6">Bagikan informasi menarik ini ke teman dan keluarga Anda.</p>
                    
                    <div class="flex flex-wrap gap-3">
                        <a href="#" class="flex-1 flex items-center justify-center gap-2 bg-white/20 hover:bg-white/30 p-3 rounded-xl transition-colors text-sm font-medium">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                        </a>
                        <a href="#" class="flex-1 flex items-center justify-center gap-2 bg-white/20 hover:bg-white/30 p-3 rounded-xl transition-colors text-sm font-medium">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.894 8.221l-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.446 1.394c-.14.18-.357.223-.548.223l.188-2.85 5.18-4.68c.223-.198-.054-.31-.346-.11l-6.4 4.02-2.76-.86c-.6-.185-.613-.6.125-.89l10.73-4.13c.5-.18.96.115.83.9l-.5 3.515z"/></svg>
                        </a>
                        <button onclick="navigator.clipboard.writeText(window.location.href); alert('Tautan disalin!')" class="flex-1 flex items-center justify-center gap-2 bg-white/20 hover:bg-white/30 p-3 rounded-xl transition-colors text-sm font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                        </button>
                    </div>
                </div>

                {{-- Related Articles --}}
                @if($related->count() > 0)
                    <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-zinc-100 dark:border-zinc-800/60 p-6">
                        <div class="flex items-center gap-2 mb-6 pb-4 border-b border-zinc-100 dark:border-zinc-800">
                            <div class="w-2 h-6 rounded-full bg-emerald-500"></div>
                            <h3 class="text-xl font-extrabold text-zinc-900 dark:text-white">Terkait</h3>
                        </div>
                        
                        <div class="space-y-6">
                            @foreach($related as $relArticle)
                                <div class="flex gap-4 group">
                                    <a href="{{ route('articles.detail', $relArticle->slug) }}" class="block shrink-0 w-24 h-24 rounded-xl overflow-hidden bg-zinc-100 dark:bg-zinc-800">
                                        @if($relArticle->image)
                                            <img src="{{ Storage::url($relArticle->image) }}" alt="" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-indigo-50 dark:bg-indigo-900/20 text-indigo-200">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            </div>
                                        @endif
                                    </a>
                                    <div>
                                        <h4 class="font-serif font-bold text-sm text-zinc-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors leading-snug mb-2">
                                            <a href="{{ route('articles.detail', $relArticle->slug) }}" class="line-clamp-3">
                                                {{ $relArticle->title }}
                                            </a>
                                        </h4>
                                        <div class="text-[10px] text-zinc-500 font-medium uppercase tracking-wider">
                                            {{ $relArticle->published_at->locale('id')->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                
            </aside>
        </div>
    </article>
</x-portal-layout>
