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
                        wire:click.live="selectExercise({{ $exercise->id }})"
                        @click="open = false"
                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                    >
                        {{ $exercise->name }}
                    </button>
                @endforeach
            </div>
        @endif

        <input type="hidden" name="exercise_id" value="{{ $selectedExercise ? $selectedExercise->id : '' }}" required>
    </div>

    @if($selectedExercise && count($previousMetrics) > 0)
        <div class="mt-4">
            <h4 class="text-sm font-medium text-gray-700 mb-2">Previous Metrics</h4>
            <div class="space-y-2">
                @foreach($previousMetrics as $metric)
                    <button
                        type="button"
                        wire:click="selectMetric({{ $metric->id }})"
                        class="w-full text-left px-4 py-2 text-sm bg-gray-50 hover:bg-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    >
                        <div class="flex justify-between items-center">
                            <div>
                                {{ $metric->performed_at ? $metric->performed_at->format('M d, Y') : 'No date' }}
                            </div>
                            <div class="text-gray-600">
                                @if($metric->load)
                                    {{ $metric->load }}lbs
                                @endif
                                @if($metric->reps)
                                    × {{ $metric->reps }} reps
                                @endif
                                @if($metric->sets)
                                    × {{ $metric->sets }} sets
                                @endif
                            </div>
                        </div>
                    </button>
                @endforeach
            </div>
        </div>
    @endif
</div> 