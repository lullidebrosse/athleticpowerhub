<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Log New Metric') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('metrics.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <!-- Exercise Selection using Livewire -->
                        <livewire:exercise-search />

                        <!-- Metric Type -->
                        <div>
                            <label for="metric_type" class="block text-sm font-medium text-gray-700">Metric Type</label>
                            <select name="metric_type" id="metric_type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="">Select metric type</option>
                                <option value="MAX_WEIGHT">Max Weight</option>
                                <option value="REP_MAX">Rep Max</option>
                                <option value="DENSITY">Density</option>
                                <option value="TIME">Time</option>
                                <option value="DISTANCE">Distance</option>
                                <option value="HEIGHT">Height</option>
                                <option value="SPEED">Speed</option>
                            </select>
                            @error('metric_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Dynamic Fields based on Metric Type -->
                        <div id="max-weight-fields" class="hidden space-y-4">
                            <div>
                                <label for="load" class="block text-sm font-medium text-gray-700">Weight (lbs)</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input type="number" step="0.01" name="load" id="load" value="{{ old('load') }}"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">lbs</span>
                                    </div>
                                </div>
                                @error('load')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div id="rep-max-fields" class="hidden space-y-4">
                            <div>
                                <label for="load_rm" class="block text-sm font-medium text-gray-700">Weight (lbs)</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input type="number" step="0.01" name="load" id="load_rm" value="{{ old('load') }}"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">lbs</span>
                                    </div>
                                </div>
                                @error('load')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="reps" class="block text-sm font-medium text-gray-700">Repetitions</label>
                                <input type="number" name="reps" id="reps" value="{{ old('reps') }}"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('reps')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div id="density-fields" class="hidden space-y-4">
                            <div>
                                <label for="load_density" class="block text-sm font-medium text-gray-700">Weight (lbs)</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input type="number" step="0.01" name="load" id="load_density" value="{{ old('load') }}"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">lbs</span>
                                    </div>
                                </div>
                                @error('load')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="reps_density" class="block text-sm font-medium text-gray-700">Repetitions per Set</label>
                                <input type="number" name="reps" id="reps_density" value="{{ old('reps') }}"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('reps')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="sets" class="block text-sm font-medium text-gray-700">Number of Sets</label>
                                <input type="number" name="sets" id="sets" value="{{ old('sets') }}"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('sets')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="duration" class="block text-sm font-medium text-gray-700">Duration (seconds)</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input type="number" step="0.01" name="duration" id="duration" value="{{ old('duration') }}"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">sec</span>
                                    </div>
                                </div>
                                @error('duration')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div id="time-fields" class="hidden space-y-4">
                            <div>
                                <label for="duration_time" class="block text-sm font-medium text-gray-700">Time (seconds)</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input type="number" step="0.01" name="duration" id="duration_time" value="{{ old('duration') }}"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">sec</span>
                                    </div>
                                </div>
                                @error('duration')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div id="distance-fields" class="hidden space-y-4">
                            <div>
                                <label for="distance" class="block text-sm font-medium text-gray-700">Distance (meters)</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input type="number" step="0.01" name="distance" id="distance" value="{{ old('distance') }}"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">m</span>
                                    </div>
                                </div>
                                @error('distance')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div id="height-fields" class="hidden space-y-4">
                            <div>
                                <label for="height" class="block text-sm font-medium text-gray-700">Height (inches)</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input type="number" step="0.01" name="height" id="height" value="{{ old('height') }}"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">in</span>
                                    </div>
                                </div>
                                @error('height')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div id="speed-fields" class="hidden space-y-4">
                            <div>
                                <label for="speed" class="block text-sm font-medium text-gray-700">Speed (mph)</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input type="number" step="0.01" name="speed" id="speed" value="{{ old('speed') }}"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">mph</span>
                                    </div>
                                </div>
                                @error('speed')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Common Fields for All Metric Types -->
                        <div class="space-y-4">
                            <!-- Performed At Date -->
                            <div>
                                <label for="performed_at" class="block text-sm font-medium text-gray-700">Date Performed</label>
                                <input 
                                    type="datetime-local" 
                                    name="performed_at" 
                                    id="performed_at" 
                                    value="{{ old('performed_at', now()->format('Y-m-d\TH:i')) }}"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                >
                                @error('performed_at')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Notes -->
                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                                <textarea 
                                    name="notes" 
                                    id="notes" 
                                    rows="3" 
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                    placeholder="Add any additional notes about this metric..."
                                >{{ old('notes') }}</textarea>
                                @error('notes')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Log Metric
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('metric_type').addEventListener('change', function() {
            // Hide all field groups first
            document.querySelectorAll('[id$="-fields"]').forEach(el => el.classList.add('hidden'));
            
            // Show the relevant field group based on selection
            const selectedType = this.value;
            if (selectedType) {
                document.getElementById(`${selectedType.toLowerCase()}-fields`).classList.remove('hidden');
            }
        });
    </script>
    @endpush
</x-app-layout> 