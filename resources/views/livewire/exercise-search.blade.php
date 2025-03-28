<div>
    <div class="mb-6">
        <div class="relative">
            <input
                type="text"
                wire:model.live="search"
                placeholder="Search exercises..."
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
            >
            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                </svg>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($exercises as $exercise)
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
        @empty
            <div class="col-span-full text-center py-8">
                <p class="text-gray-500">No exercises found matching your search.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $exercises->links() }}
    </div>
</div> 