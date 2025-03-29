<div>
    <div class="mb-8 space-y-6">
        <!-- Filters -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div>
                    <label for="exercise" class="block text-sm font-medium text-gray-700 mb-1">Exercise</label>
                    <select wire:model.live="selectedExercise" id="exercise" 
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">All Exercises</option>
                        @foreach($exercises as $exercise)
                            <option value="{{ $exercise->id }}">{{ $exercise->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="dateFrom" class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                    <input type="date" wire:model.live="dateFrom" id="dateFrom" 
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="dateTo" class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                    <input type="date" wire:model.live="dateTo" id="dateTo" 
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="perPage" class="block text-sm font-medium text-gray-700 mb-1">Results Per Page</label>
                    <select wire:model.live="perPage" id="perPage" 
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Sort Options -->
        <div class="flex items-center space-x-4 text-sm text-gray-600">
            <span class="font-medium">Sort by:</span>
            <button wire:click="sortBy('log_date')" 
                    class="flex items-center space-x-1 hover:text-gray-900 transition-colors duration-150">
                <span>Date</span>
                @if($sortBy === 'log_date')
                    <span class="text-indigo-600">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                @endif
            </button>
            <button wire:click="sortBy('exercise.name')" 
                    class="flex items-center space-x-1 hover:text-gray-900 transition-colors duration-150">
                <span>Exercise</span>
                @if($sortBy === 'exercise.name')
                    <span class="text-indigo-600">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                @endif
            </button>
        </div>
    </div>

    @if($exerciseLogs->isEmpty())
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No exercise logs found</h3>
            <p class="mt-1 text-sm text-gray-500">Start by logging your first exercise!</p>
            <div class="mt-6">
                <a href="{{ route('exercises.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Log New Exercise
                </a>
            </div>
        </div>
    @else
        <div class="space-y-8">
            @foreach($groupedLogs as $month => $logs)
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-6 pb-2 border-b border-gray-200">{{ $month }}</h3>
                    <div class="space-y-6">
                        @foreach($logs as $log)
                            <div class="bg-white border border-gray-200 rounded-lg p-6 relative hover:shadow-md transition-shadow duration-200">
                                <div class="absolute -left-3 top-6 w-2 h-2 bg-indigo-600 rounded-full"></div>
                                @if(!$loop->last)
                                    <div class="absolute -left-3 top-8 w-0.5 h-full bg-gray-200"></div>
                                @endif
                                
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <div class="flex items-center gap-3">
                                            <h3 class="text-lg font-semibold text-gray-900">{{ $log->exercise->name }}</h3>
                                            <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded-full">
                                                {{ $log->log_date->format('F j, Y') }}
                                            </span>
                                        </div>
                                        <div class="mt-3 text-sm text-gray-600">
                                            @php
                                                $totalSets = $log->setEntries->count();
                                                $totalReps = $log->setEntries->sum('reps');
                                                $maxWeight = $log->setEntries->max('weight');
                                                $maxWeightUnit = $log->setEntries->where('weight', $maxWeight)->first()?->weight_unit;
                                                $totalDistance = $log->setEntries->sum('distance');
                                                $distanceUnit = $log->setEntries->first()?->distance_unit;
                                                $totalTime = $log->setEntries->sum('time');
                                                $timeUnit = $log->setEntries->first()?->time_unit;
                                            @endphp
                                            <div class="flex flex-wrap gap-4">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $totalSets }} sets
                                                </span>
                                                @if($totalReps > 0)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        {{ $totalReps }} total reps
                                                    </span>
                                                @endif
                                                @if($maxWeight > 0)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                        Max: {{ $maxWeight }} {{ $maxWeightUnit }}
                                                    </span>
                                                @endif
                                                @if($totalDistance > 0)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        Total: {{ $totalDistance }} {{ $distanceUnit }}
                                                    </span>
                                                @endif
                                                @if($totalTime > 0)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        Time: {{ $totalTime }} {{ $timeUnit }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button wire:click="copyLastWorkout({{ $log->id }})"
                                                class="inline-flex items-center px-3 py-1.5 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                            </svg>
                                            Copy
                                        </button>
                                        <a href="{{ route('exercises.index') }}" 
                                           class="inline-flex items-center px-3 py-1.5 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                            Log New
                                        </a>
                                    </div>
                                </div>

                                @if($log->notes)
                                    <div class="bg-gray-50 p-3 rounded-md mb-4">
                                        <p class="text-sm text-gray-600">{{ $log->notes }}</p>
                                    </div>
                                @endif

                                <div x-data="{ showDetails: false }">
                                    <button @click="showDetails = !showDetails" 
                                            class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-900 mb-4">
                                        <svg class="w-4 h-4 mr-1" :class="{ 'transform rotate-180': showDetails }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                        <span x-text="showDetails ? 'Hide Details' : 'Show Details'"></span>
                                    </button>

                                    <div x-show="showDetails" x-collapse class="space-y-3">
                                        @foreach($log->setEntries as $set)
                                            <div class="bg-gray-50 p-4 rounded-md">
                                                <div class="flex justify-between items-start">
                                                    <div class="space-y-1">
                                                        <div class="flex items-center gap-2">
                                                            <span class="font-medium text-gray-900">Set {{ $set->set_number }}</span>
                                                            @if($set->reps)
                                                                <span class="text-sm text-gray-600">{{ $set->reps }} reps</span>
                                                            @endif
                                                            @if($set->weight)
                                                                <span class="text-sm text-gray-600">{{ $set->weight }} {{ $set->weight_unit }}</span>
                                                            @endif
                                                            @if($set->time)
                                                                <span class="text-sm text-gray-600">{{ $set->time }} {{ $set->time_unit }}</span>
                                                            @endif
                                                            @if($set->distance)
                                                                <span class="text-sm text-gray-600">{{ $set->distance }} {{ $set->distance_unit }}</span>
                                                            @endif
                                                        </div>
                                                        @if($set->rest_duration_after_set)
                                                            <span class="text-xs text-gray-500">Rest: {{ $set->rest_duration_after_set }}s</span>
                                                        @endif
                                                    </div>
                                                    @if($set->meta_data)
                                                        <div class="text-sm text-gray-500 bg-white p-2 rounded border border-gray-200">
                                                            {{ json_decode($set->meta_data)->notes }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $exerciseLogs->links() }}
        </div>
    @endif
</div> 