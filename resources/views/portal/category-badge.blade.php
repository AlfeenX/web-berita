@props(['category'])

@php
    $colors = [
        'Technology' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
        'Business' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400',
        'Startup' => 'bg-violet-100 text-violet-700 dark:bg-violet-900/30 dark:text-violet-400',
        'Lifestyle' => 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400',
        'Programming' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
        'Gaming' => 'bg-fuchsia-100 text-fuchsia-700 dark:bg-fuchsia-900/30 dark:text-fuchsia-400',
    ];
    
    $colorClass = $colors[$category->name] ?? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400';
@endphp

<a href="{{ route('home', ['category' => $category->slug]) }}" 
   class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold tracking-wider uppercase transition-colors hover:opacity-80 {{ $colorClass }}">
    {{ $category->name }}
</a>
