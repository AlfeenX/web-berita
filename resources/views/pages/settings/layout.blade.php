<div class="w-full">
    <!-- Main content box with integrated tab header -->
    <div class="w-full bg-white dark:bg-zinc-900/50 rounded-2xl border border-zinc-200/80 dark:border-zinc-800/80 shadow-sm overflow-hidden backdrop-blur-xl">
        <!-- Tab Navigation (Pills) -->
        <div class="px-6 pt-6 pb-2 border-b border-zinc-100 dark:border-zinc-800/50 bg-zinc-50/50 dark:bg-zinc-900/50">
            <nav class="flex overflow-x-auto gap-2 pb-2">
                <a href="{{ route('profile.edit') }}" wire:navigate
                    class="px-4 py-2 text-sm font-medium transition-all duration-200 rounded-xl flex items-center gap-2 whitespace-nowrap {{ request()->routeIs('profile.edit') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-500/20' : 'bg-transparent text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-100 hover:bg-zinc-200/50 dark:hover:bg-zinc-800/50' }}">
                    <flux:icon.user class="size-4" />
                    {{ __('Profile') }}
                </a>
                <a href="{{ route('security.edit') }}" wire:navigate
                    class="px-4 py-2 text-sm font-medium transition-all duration-200 rounded-xl flex items-center gap-2 whitespace-nowrap {{ request()->routeIs('security.edit') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-500/20' : 'bg-transparent text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-100 hover:bg-zinc-200/50 dark:hover:bg-zinc-800/50' }}">
                    <flux:icon.shield-check class="size-4" />
                    {{ __('Security') }}
                </a>
                <a href="{{ route('appearance.edit') }}" wire:navigate
                    class="px-4 py-2 text-sm font-medium transition-all duration-200 rounded-xl flex items-center gap-2 whitespace-nowrap {{ request()->routeIs('appearance.edit') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-500/20' : 'bg-transparent text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-100 hover:bg-zinc-200/50 dark:hover:bg-zinc-800/50' }}">
                    <flux:icon.paint-brush class="size-4" />
                    {{ __('Appearance') }}
                </a>
            </nav>
        </div>

        <!-- Content Area -->
        <div class="p-6 md:p-8">
            <div class="mb-8 border-b border-zinc-100 dark:border-zinc-800/50 pb-6">
                <flux:heading size="lg">{{ $heading ?? '' }}</flux:heading>
                <flux:subheading>{{ $subheading ?? '' }}</flux:subheading>
            </div>

            <div class="w-full max-w-2xl">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
