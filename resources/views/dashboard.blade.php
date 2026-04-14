@if(Auth::check())
<x-app-layout>
    <section class="relative bg-white dark:bg-gray-900 pt-16 pb-20 lg:pt-24 lg:pb-28">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-6xl">
                    <span class="block">The Community</span>
                    <span class="block text-indigo-600">Closet Project</span>
                </h1>
                <p class="mt-6 max-w-2xl mx-auto text-lg text-gray-500 dark:text-gray-400">
                    Participate in a circular economy to reduce waste and improve the community.
                </p>
                <div class="mt-10 flex flex-col sm:flex-row justify-center gap-4">
                    <a href="/closet" class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 md:text-lg transition-all shadow-md">
                        Start Browsing
                    </a>
                    <a href="/lend" class="inline-flex items-center justify-center px-8 py-3 border border-gray-300 dark:border-gray-700 text-base font-bold rounded-xl text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 md:text-lg transition-all shadow-sm">
                        Lend an Item
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-gray-50 dark:bg-gray-800/50 py-20">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="mb-12">
                <h2 class="text-sm font-semibold text-indigo-600 uppercase tracking-wide">Simple Process</h2>
                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">How it works</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <div class="text-indigo-600 mb-4 font-black text-4xl">01</div>
                    <h3 class="text-xl font-bold dark:text-white mb-2">Request</h3>
                    <p class="text-gray-500 dark:text-gray-400 leading-relaxed">
                        Browse our neighborhood catalog and send a request for the dates you need.
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <div class="text-indigo-600 mb-4 font-black text-4xl">02</div>
                    <h3 class="text-xl font-bold dark:text-white mb-2">Approve</h3>
                    <p class="text-gray-500 dark:text-gray-400 leading-relaxed">
                        Lenders review the request. Once approved, you'll get a notification to pick it up.
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <div class="text-indigo-600 mb-4 font-black text-4xl">03</div>
                    <h3 class="text-xl font-bold dark:text-white mb-2">Exchange</h3>
                    <p class="text-gray-500 dark:text-gray-400 leading-relaxed">
                        Meet up, use the item, and return it. Rate your experience to keep the community safe.
                    </p>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
@else
<x-guest-layout>
    <div class="flex font-bold text-xl text-gray-800 dark:text-gray-200 justify-center py-2">
        <h1>{{__('Welcome to the Community Closet!')}}</h1>
    </div>
    <div class="flex justify-around py-2">
        <button onclick="window.location='{{route("login")}}'" class="inline-flex items-center py-4 px-8 rounded bg-indigo-200 dark:bg-indigo-800 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-white uppercase tracking-widest hover:bg-indigo-100 dark:hover:bg-indigo-700 focus:bg-indigo-100 dark:focus:bg-indigo-700 active:bg-white dark:active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
            {{__('Log In')}}
        </button>

        <button onclick="window.location='{{route("register")}}'" class="inline-flex items-center py-4 px-8 rounded bg-indigo-200 dark:bg-indigo-800 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-white uppercase tracking-widest hover:bg-indigo-100 dark:hover:bg-indigo-700 focus:bg-indigo-100 dark:focus:bg-indigo-700 active:bg-white dark:active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
            {{__('Register')}}
        </button>
    </div>
</x-guest-layout>
@endif
