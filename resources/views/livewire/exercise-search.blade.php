<div>
    <div class="relative" x-data="{ open: false }" @click.away="open = false">
        <label for="exercise_search" class="block text-sm font-medium text-gray-700">Exercise</label>
        <div class="mt-1 relative">
            <input 
                type="text" 
                wire:model.live="search"
                id="exercise_search"
                @focus="open = true"
                class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                placeholder="Search for an exercise..."
            >
            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                </svg>
            </div>
        </div>

        @if(count($exercises) > 0)
            <div 
                x-show="open"
                class="fixed w-[calc(100%-2rem)] md:w-auto md:min-w-[20rem] z-50 mt-1 bg-white shadow-lg rounded-md py-1 max-h-60 overflow-y-auto"
                style="position: absolute; left: 0; right: 0;"
            >
                @foreach($exercises as $exercise)
                    <button
                        type="button"
                        wire:click="selectExercise({{ $exercise->id }})"
                        @click="open = false"
                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                    >
                        {{ $exercise->name }}
                    </button>
                @endforeach
            </div>
        @endif

        <input type="hidden" name="exercise_id" value="{{ $selectedExercise ? $selectedExercise->id : '' }}">
    </div>
</div> 