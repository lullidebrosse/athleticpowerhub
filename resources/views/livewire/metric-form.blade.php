<div>
    <form wire:submit="store" class="space-y-6">
        @csrf
        
        <!-- Tracked Exercises -->
        <livewire:tracked-exercises />
        
        <!-- Exercise Selection using Livewire -->
        <livewire:exercise-search />
        <input type="hidden" wire:model="metric_type" value="MAX_WEIGHT">
        <input type="hidden" wire:model="exercise_id" name="exercise_id" id="exercise_id">

        <!-- All Metric Input Fields -->
        <div class="mt-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Performance Metrics</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Strength Metrics -->
                <div class="space-y-4">
                    <h4 class="text-sm font-medium text-gray-700">Strength</h4>
                    <!-- Load/Weight -->
                    <div>
                        <label for="load" class="block text-sm font-medium text-gray-700">Weight (lbs)</label>
                        <input type="number" step="0.01" wire:model="load" id="load"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        @error('load')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Reps -->
                    <div>
                        <label for="reps" class="block text-sm font-medium text-gray-700">Repetitions</label>
                        <input type="number" wire:model="reps" id="reps"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        @error('reps')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sets -->
                    <div>
                        <label for="sets" class="block text-sm font-medium text-gray-700">Number of Sets</label>
                        <input type="number" wire:model="sets" id="sets"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        @error('sets')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Endurance Metrics -->
                <div class="space-y-4">
                    <h4 class="text-sm font-medium text-gray-700">Endurance</h4>
                    <!-- Duration -->
                    <div>
                        <label for="duration" class="block text-sm font-medium text-gray-700">Duration (sec)</label>
                        <input type="number" step="0.01" wire:model="duration" id="duration"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        @error('duration')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Distance -->
                    <div>
                        <label for="distance" class="block text-sm font-medium text-gray-700">Distance (m)</label>
                        <input type="number" step="0.01" wire:model="distance" id="distance"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        @error('distance')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Speed -->
                    <div>
                        <label for="speed" class="block text-sm font-medium text-gray-700">Speed (mph)</label>
                        <input type="number" step="0.01" wire:model="speed" id="speed"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        @error('speed')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Power Metrics -->
                <div class="space-y-4">
                    <h4 class="text-sm font-medium text-gray-700">Power</h4>
                    <!-- Height -->
                    <div>
                        <label for="height" class="block text-sm font-medium text-gray-700">Height (in)</label>
                        <input type="number" step="0.01" wire:model="height" id="height"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        @error('height')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Common Fields for All Metric Types -->
        <div class="mt-8 space-y-4">
            <h3 class="text-lg font-medium text-gray-900">Additional Information</h3>
            <!-- Performed At Date -->
            <div>
                <label for="performed_at" class="block text-sm font-medium text-gray-700">Date Performed</label>
                <input 
                    type="datetime-local" 
                    wire:model="performed_at" 
                    id="performed_at" 
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
                    wire:model="notes" 
                    id="notes" 
                    rows="3" 
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                    placeholder="Add any additional notes about this metric..."
                ></textarea>
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