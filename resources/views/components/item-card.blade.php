@props(['listing'])

@php
    $requested = $listing->isRequested();
@endphp

<div x-data="{open: false}">
<div class="my-5 ml-4 bg-white dark:bg-gray-700 border-2 border-gray-700 dark:border-gray-600 rounded-lg">
    <div class="cursor-pointer" @click="open = true">
        @if($listing->image)
            <img class="w-full h-48 object-cover rounded-lg" src="{{ asset('storage/' . $listing->image) }}" alt="{{ $listing->title }}">
        @else
            <div class="w-full h-48 rounded-lg bg-gray-400 flex items-center justify-center text-gray-100">
                No Image Available
            </div>
        @endif
    </div>

    <div class="p-4">
        <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-gray-100 truncate">
            {{ $listing->title }}
        </h5>

        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
            Owned by {{ $listing->owner->name ?? 'User' }}
        </p>

        <p class="text-gray-700 dark:text-gray-200 text-sm line-clamp-2 mb-4">
            {{ $listing->description }}
        </p>

        <div class="flex items-center justify-between">
        @if ($requested)
            <span class="inline-block bg-yellow-200 dark:bg-yellow-800 text-yellow-800 dark:text-yellow-100 text-xs px-2 py-1 rounded-full uppercase font-bold">
            {{__('pending')}}
            </span>
            <button disabled class="text-gray-200 bg-gray-200 dark:bg-gray-600 font-medium rounded-lg text-sm px-3 py-2 text-center">
                View Details
            </button>
        @else
            <span class="inline-block bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-100 text-xs px-2 py-1 rounded-full uppercase font-bold">
            {{__('available')}}
            </span>
            <button @click="open = true" class="text-white bg-indigo-200 dark:bg-indigo-600 hover:bg-indigo-400 hover:dark:bg-indigo-800 font-medium rounded-lg text-sm px-3 py-2 text-center">
                View Details
            </button>
        @endif
        </div>
    </div>
</div>
<div x-show="open"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 px-4"
    x-cloak> <div @click.away="open = false" class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-lg w-full p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Borrow {{ $listing->title }}</h3>
            <button @click="open = false" class="text-2xl text-gray-500 dark:text-gray-400 hover:text-black hover:dark:text-gray-200">&times;</button>
        </div>

        <form action="/borrow/{{ $listing->id }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-800 dark:text-gray-200">Start Date</label>
                    <input type="date" name="start_date" class="w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-800 dark:text-gray-200">End Date</label>
                    <input type="date" name="end_date" class="w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
                <button type="submit" class="w-full bg-indigo-200 dark:bg-indigo-600 text-gray-200 dark:text-white py-2 rounded-md hover:bg-indigo-400 hover:dark:bg-indigo-800">
                    Confirm Request
                </button>
            </div>
        </form>
    </div>
</div>
</div>
