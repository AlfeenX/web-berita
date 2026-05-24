@props([
    'sidebar' => false,
])

@if($sidebar)
    <a {{ $attributes }} class="flex items-center gap-2">
        <img src="{{ asset('images/logo-removed-bg.png') }}" alt="{{ config('app.name', 'PareDaily') }}" class="h-8 w-auto dark:brightness-110">
    </a>
@else
<img src="{{ asset('images/logo-removed-bg.png') }}" alt="{{ config('app.name', 'Laravel') }}" {{ $attributes }} class="h-10">
@endif
