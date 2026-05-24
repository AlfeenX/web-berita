@props(['articles'])

<div x-data="{ 
        activeSlide: 0, 
        timer: null,
        startTimer() {
            this.stopTimer();
            this.timer = setInterval(() => { 
                this.activeSlide = this.activeSlide === {{ count($articles) - 1 }} ? 0 : this.activeSlide + 1;
            }, 5000);
        },
        stopTimer() {
            if (this.timer) clearInterval(this.timer);
        },
        next() {
            this.activeSlide = this.activeSlide === {{ count($articles) - 1 }} ? 0 : this.activeSlide + 1;
            this.startTimer();
        },
        prev() {
            this.activeSlide = this.activeSlide === 0 ? {{ count($articles) - 1 }} : this.activeSlide - 1;
            this.startTimer();
        },
        goTo(index) {
            this.activeSlide = index;
            this.startTimer();
        }
     }" 
     x-init="startTimer()"
     class="relative w-full bg-zinc-950 overflow-hidden" 
     @mouseenter="stopTimer()" 
     @mouseleave="startTimer()">

    <div class="relative aspect-[16/9] lg:aspect-[21/9] w-full">
        @foreach($articles as $index => $article)
            <div x-show="activeSlide === {{ $index }}" 
                 x-transition:enter="transition ease-out duration-700" 
                 x-transition:enter-start="opacity-0 scale-105" 
                 x-transition:enter-end="opacity-100 scale-100" 
                 x-transition:leave="transition ease-in duration-500 absolute inset-0" 
                 x-transition:leave-start="opacity-100" 
                 x-transition:leave-end="opacity-0" 
                 class="absolute inset-0 w-full h-full"
                 x-cloak>
                
                {{-- Background Image --}}
                @if($article->image)
                    <img src="{{ Storage::url($article->image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-indigo-900 to-zinc-900"></div>
                @endif
                
                {{-- Gradients --}}
                <div class="absolute inset-0 bg-gradient-to-t from-zinc-950 via-zinc-950/60 to-transparent"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-zinc-950/80 to-transparent"></div>
                
                {{-- Content --}}
                <div class="absolute inset-0 flex flex-col justify-end">
                    <div class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 pb-12 lg:pb-20">
                        <div class="max-w-3xl">
                            <div class="mb-4 translate-y-4 opacity-0 transition-all duration-700 delay-300" :class="{ 'translate-y-0 opacity-100': activeSlide === {{ $index }} }">
                                @include('portal.category-badge', ['category' => $article->category])
                            </div>
                            
                            <h2 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white leading-tight mb-4 translate-y-4 opacity-0 transition-all duration-700 delay-500" :class="{ 'translate-y-0 opacity-100': activeSlide === {{ $index }} }">
                                <a href="{{ route('articles.detail', $article->slug) }}" class="hover:text-indigo-200 transition-colors line-clamp-3">
                                    {{ $article->title }}
                                </a>
                            </h2>
                            
                            <p class="text-zinc-300 text-sm sm:text-base lg:text-lg line-clamp-2 mb-6 max-w-2xl translate-y-4 opacity-0 transition-all duration-700 delay-700" :class="{ 'translate-y-0 opacity-100': activeSlide === {{ $index }} }">
                                {{ $article->excerpt }}
                            </p>
                            
                            <div class="flex items-center gap-4 text-xs sm:text-sm text-zinc-400 font-medium translate-y-4 opacity-0 transition-all duration-700 delay-[900ms]" :class="{ 'translate-y-0 opacity-100': activeSlide === {{ $index }} }">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-zinc-800 flex items-center justify-center text-indigo-400 shrink-0">
                                        @if($article->user->profile?->avatar)
                                            <img src="{{ Storage::url($article->user->profile->avatar) }}" alt="" class="w-full h-full rounded-full object-cover">
                                        @else
                                            <span class="text-xs font-bold">{{ $article->user->initials() }}</span>
                                        @endif
                                    </div>
                                    <span class="text-zinc-200">{{ $article->user->name }}</span>
                                </div>
                                <span class="w-1 h-1 rounded-full bg-zinc-600"></span>
                                <span>{{ $article->published_at->locale('id')->isoFormat('D MMMM Y') }}</span>
                                <span class="w-1 h-1 rounded-full bg-zinc-600 hidden sm:block"></span>
                                <span class="hidden sm:inline">{{ $article->reading_time }} mnt baca</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Controls --}}
    <div class="absolute bottom-6 right-0 left-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-end gap-3">
            <button @click="prev()" class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-md flex items-center justify-center text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <button @click="next()" class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-md flex items-center justify-center text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>
    </div>
    
    {{-- Indicators --}}
    <div class="absolute bottom-0 left-0 right-0 h-1 flex">
        @foreach($articles as $index => $article)
            <div class="flex-1 h-full bg-white/20 cursor-pointer" @click="goTo({{ $index }})">
                <div class="h-full bg-indigo-500"
                     :class="activeSlide === {{ $index }} ? 'w-full transition-all duration-[5000ms] ease-linear' : 'w-0 transition-none'"></div>
            </div>
        @endforeach
    </div>
</div>
