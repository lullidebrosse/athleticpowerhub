<div>
    <div class="mb-6">
        <div class="relative">
            <input
                type="text"
                wire:model.live="search"
                placeholder="Start typing to search exercises..."
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                autofocus
            >
            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                </svg>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @if(strlen(trim($search)) === 0)
            <div class="col-span-full flex items-center justify-center min-h-[400px]">
                <div class="max-w-md text-center">
                    <svg class="h-12 w-12 text-gray-400 mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Welcome to Exercise Search</h3>
                    <p class="text-gray-500">Start typing in the search box above to find exercises you want to log.</p>
                </div>
            </div>
        @elseif($exercises->isEmpty())
            <div class="col-span-full text-center py-8">
                <div class="max-w-md mx-auto">
                    <svg class="h-12 w-12 text-gray-400 mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Exercises Found</h3>
                    <p class="text-gray-500">Try adjusting your search terms to find what you're looking for.</p>
                </div>
            </div>
        @else
            @foreach ($exercises as $exercise)
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $exercise->name }}</h3>
                    @if ($exercise->description)
                        <p class="text-gray-600 text-sm mb-4">{{ $exercise->description }}</p>
                    @endif
                    <div class="flex justify-end">
                        <a href="{{ route('exercise-logs.create', $exercise) }}" 
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Log Exercise
                        </a>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div> 