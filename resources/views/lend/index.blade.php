<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Lend') }}
        </h2>
    </x-slot>
<div x-data="{ showCreateModal: false }" class="max-w-6xl mx-auto p-6">

    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-200">My Listings</h1>
        <button @click="showCreateModal = true" class="bg-indigo-600 hover:bg-indigo-800 text-white font-bold py-2 px-6 rounded-lg shadow-lg transition">
            Create Item
        </button>
    </div>

        <div class="bg-white dark:bg-gray-700 rounded-xl overflow-hidden">
            <div class="divide-y divide-gray-200">
                @forelse($myListings as $item)
                    <div x-data="{ showEditModal: false }">

                        <div class="p-4 flex items-center justify-between hover:bg-gray-50 hover:dark:bg-gray-600 transition">
                            <div class="flex items-center space-x-4">
                                @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" class="w-16 h-16 object-cover rounded-lg">
                                @else
                                    <div class="w-16 h-16 rounded-lg bg-gray-400 flex items-center justify-center text-gray-100 text-xs">
                                        No Image
                                    </div>
                                @endif
                                <div>
                                    <h3 class="font-bold text-lg text-gray-900 dark:text-gray-200">{{ $item->title }}</h3>
                                    <span class="text-xs uppercase px-2 py-1 rounded-full font-semibold {{ $item->status == 'available' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                        {{ $item->status }}
                                    </span>
                                </div>
                                                        </div><div class="flex-1 px-8">
                                @php
                                    $pendingRequest = $item->requests->where('status', 'requested')->first();
                                    $activeRequest = $item->requests->where('status', 'approved')->first();
                                @endphp

                                @if($pendingRequest)
                                    <div class="bg-indigo-50 dark:bg-indigo-900/30 border border-indigo-100 dark:border-indigo-800 p-3 rounded-xl flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-bold text-indigo-900 dark:text-indigo-200">
                                                Request from {{ $pendingRequest->borrower->name ?? 'User' }}
                                            </p>
                                            <p class="text-xs text-indigo-700 dark:text-indigo-300">
                                                {{ $pendingRequest->start_date }} to {{ $pendingRequest->end_date }}
                                            </p>
                                        </div>
                                        <div class="flex space-x-2 mt-2">
                                            <form action="/lend/{{ $pendingRequest->id }}/approve" method="POST" onsubmit="return confirm('Are you sure you want to approve this request?');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white text-xs font-bold py-2 px-4 rounded-lg shadow-sm transition">
                                                    Approve
                                                </button>
                                            </form>
                                            <form action="/lend/{{ $pendingRequest->id }}/reject" method="POST" onsubmit="return confirm('Are you sure you want to decline this request?');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-xs font-bold py-2 px-4 rounded-lg shadow-sm transition">
                                                    Decline
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                @elseif($activeRequest)
                                    <div class="bg-indigo-50 dark:bg-indigo-900/30 border border-indigo-100 dark:border-indigo-800 p-3 rounded-xl flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-bold text-indigo-900 dark:text-indigo-200">
                                                Currently out with {{ $activeRequest->borrower->name ?? 'User' }}
                                            </p>
                                            <p class="text-xs text-indigo-700 dark:text-indigo-300">
                                                Expected back: {{ $activeRequest->end_date }}
                                            </p>
                                        </div>

                                        <form action="/lend/{{ $activeRequest->id }}/return" method="POST" onsubmit="return confirm('Are you sure this item has been returned fully?');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-2 px-4 rounded-lg shadow-sm transition">
                                                Confirm Return
                                            </button>
                                        </form>
                                    </div>

                                @else
                                    <div class="text-sm text-gray-400 italic">
                                        No active requests.
                                    </div>
                                @endif
                            </div>
                            <div class="flex items-center space-x-4">
                                <button @click="showEditModal = true" class="text-indigo-400 hover:text-indigo-600 font-medium">
                                    Edit Item
                                </button>
                                <form action="/lend/{{ $item->id }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item? This cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-medium">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div x-show="showEditModal"
                             class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4"
                             x-transition.opacity
                             x-cloak>

                            <div @click.away="showEditModal = false" class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-lg w-full p-8 relative">
                                <h2 class="text-2xl font-bold mb-6 dark:text-white">Edit Listing</h2>

                                <form action="/lend/{{ $item->id }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                    @csrf
                                    @method('PATCH')

                                    <div>
                                        <label class="block text-sm font-semibold dark:text-gray-200">Item Name</label>
                                        <input type="text" name="title" value="{{ $item->title }}" class="w-full mt-1 border-gray-300 rounded-lg bg-white text-gray-800" required>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold dark:text-gray-200">Description</label>
                                        <textarea name="description" rows="3" class="w-full mt-1 border-gray-300 rounded-lg bg-white text-gray-800" required>{{ $item->description }}</textarea>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold dark:text-gray-200">New Photo (Optional)</label>
                                        <input type="file" name="image" class="w-full mt-1 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                    </div>

                                    <div class="flex space-x-3">
                                        <button type="button" @click="showEditModal = false" class="flex-1 bg-gray-100 py-3 rounded-lg hover:bg-gray-200">Cancel</button>
                                        <button type="submit" class="flex-1 bg-indigo-600 text-white font-bold py-3 rounded-lg hover:bg-indigo-800">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div> @empty
                    <div class="p-12 text-center text-gray-500">
                        You haven't listed anything yet. Click the button above to start!
                    </div>
                @endforelse
            </div>
        </div>

        <div x-show="showCreateModal"
         x-transition.opacity
         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4"
         x-cloak>

        <div @click.away="showCreateModal = false"
             x-transition.scale.90
             class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-lg w-full p-6 relative">

            <button @click="showCreateModal = false" class=" text-2xl absolute top-4 right-4 text-gray-500 dark:text-gray-400 hover:text-black hover:dark:text-gray-200">&times;</button>

            <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">List a New Item</h2>

            <form action="/closet" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Item Name</label>
                    <input type="text" name="title" class="w-full mt-1 border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" placeholder="e.g. Mountain Bike" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Description</label>
                    <textarea name="description" rows="3" class="w-full mt-1 border-gray-300 rounded-lg" placeholder="Tell us about the item..." required></textarea>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Photo</label>
                    <input type="file" name="image" class="w-full mt-1 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                </div>

                <button type="submit" class="w-full bg-indigo-200 dark:bg-indigo-600 text-gray-200 dark: text-white font-bold py-3 rounded-md hover:bg-indigo-400 hover:dark:bg-indigo-800 transition">
                    Create Item
                </button>
            </form>
        </div>
    </div>
</div>
</x-app-layout>
