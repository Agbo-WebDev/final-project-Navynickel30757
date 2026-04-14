<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Closet') }}
        </h2>
    </x-slot>


    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($listings as $item)
            <x-item-card :listing="$item" />
        @empty
            <p class="col-span-full text-center text-gray-500">No items available to borrow right now.</p>
        @endforelse
    </div>
</x-app-layout>
