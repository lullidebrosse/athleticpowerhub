<div>
    @php
        Log::debug('Rendering TrackedExercises view');
    @endphp
    @if(count($trackedExercises) > 0)
        <div class="mb-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Tracked Exercises</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($trackedExercises as $exercise)
                    <button
                        type="button"
                        wire:click="selectExercise({{ $exercise->id }})"
                        class="group relative bg-white p-4 rounded-xl shadow-sm border-2 border-gray-100 hover:border-indigo-500 hover:shadow-lg transition-all duration-200 text-left overflow-hidden"
                    >
                        <!-- Background gradient effect -->
                        <div class="absolute inset-0 bg-gradient-to-r from-indigo-50 to-white opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                        
                        <!-- Content -->
                        <div class="relative flex justify-between items-center">
                            <div class="flex items-center space-x-3">
                                <!-- Exercise icon -->
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                    </div>
                                </div>
                                
                                <!-- Exercise name -->
                                <h4 class="text-sm font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors duration-200">
                                    {{ $exercise->name }}
                                </h4>
                            </div>
                            
                            <!-- Arrow icon -->
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-indigo-500 transform group-hover:translate-x-1 transition-all duration-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        
                        <!-- Hover effect overlay -->
                        <div class="absolute inset-0 bg-indigo-500 opacity-0 group-hover:opacity-5 transition-opacity duration-200"></div>
                    </button>
                @endforeach
            </div>
        </div>
    @endif
</div> 