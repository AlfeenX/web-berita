<flux:dropdown position="bottom" align="start">
    @if(auth()->user()->profile?->avatar)
        <button class="flex items-center gap-3 w-full px-2 py-1.5 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors cursor-pointer" data-test="sidebar-menu-button">
            <img src="{{ Storage::url(auth()->user()->profile->avatar) }}" alt="{{ auth()->user()->name }}" class="size-8 rounded-full object-cover ring-2 ring-zinc-200 dark:ring-zinc-700">
            <span class="flex-1 text-start text-sm font-medium text-zinc-900 dark:text-zinc-100 truncate">{{ auth()->user()->name }}</span>
            <flux:icon.chevrons-up-down class="size-4 text-zinc-400" />
        </button>
    @else
        <flux:sidebar.profile
            :name="auth()->user()->name"
            :initials="auth()->user()->initials()"
            icon:trailing="chevrons-up-down"
            data-test="sidebar-menu-button"
        />
    @endif

    <flux:menu>
        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
            @if(auth()->user()->profile?->avatar)
                <img src="{{ Storage::url(auth()->user()->profile->avatar) }}" alt="{{ auth()->user()->name }}" class="size-8 rounded-full object-cover">
            @else
                <flux:avatar
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                />
            @endif
            <div class="grid flex-1 text-start text-sm leading-tight">
                <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
            </div>
        </div>
        <flux:menu.separator />
        <flux:menu.radio.group>
            <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                {{ __('Settings') }}
            </flux:menu.item>
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <flux:menu.item
                    as="button"
                    type="submit"
                    icon="arrow-right-start-on-rectangle"
                    class="w-full cursor-pointer"
                    data-test="logout-button"
                >
                    {{ __('Log out') }}
                </flux:menu.item>
            </form>
        </flux:menu.radio.group>
    </flux:menu>
</flux:dropdown>
