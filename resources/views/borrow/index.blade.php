<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Borrow') }}
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto p-6">
        <div class="flex flex-col space-y-4">
            @forelse($requests as $req)
                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-4 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center justify-between flex-wrap gap-4">

                        <div class="flex items-center space-x-4">
                            @if($req->listing->image)
                                <img src="{{ asset('storage/' . $req->listing->image) }}" class="w-16 h-16 object-cover rounded-lg">
                            @else
                                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center text-gray-400 text-xs">No Image</div>
                            @endif

                            <div>
                                <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100">
                                    {{ $req->listing->title }}
                                </h3>
                                <p class="text-sm text-gray-500">
                                    Owner: <span class="font-medium">{{ $req->listing->owner->name ?? 'Unknown' }}</span>
                                </p>
                            </div>
                        </div>

                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            <div class="flex items-center space-x-2">
                                <span class="font-semibold">From:</span>
                                <span>{{ \Carbon\Carbon::parse($req->start_date)->format('M d, Y') }}</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="font-semibold">To:</span>
                                <span>{{ \Carbon\Carbon::parse($req->end_date)->format('M d, Y') }}</span>
                            </div>
                        </div>

                        <div class="flex items-center space-x-4">
                            @if($req->status == 'approved')
                                <span class="bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider">
                                    Successfully Borrowed
                                </span>
                            @elseif($req->status == 'requested')
                                <form action="/borrow/{{ $req->id }}" method="POST" onsubmit="return confirm('Cancel this request?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-red-500 hover:text-red-700 font-medium transition">
                                        Cancel
                                    </button>
                                </form>
                                <span class="bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider">
                                    Waiting for Owner
                                </span>
                            @elseif($req->status == 'returned')
                                <span class="bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider">
                                    Successfully Returned
                                </span>
                            @elseif($req->status == 'rejected')
                                <span class="bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider">
                                    Declined
                                </span>
                            @endif
                        </div>

                    </div>
                </div>
            @empty
                <div class="bg-white dark:bg-gray-800 rounded-xl p-12 text-center border-2 border-dashed border-gray-200 dark:border-gray-700">
                    <p class="text-gray-500 dark:text-gray-400 text-lg">You haven't requested anything yet.</p>
                    <a href="/closet" class="mt-4 inline-block text-indigo-600 hover:text-indigo-800 font-bold">Browse the Closet</a>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
