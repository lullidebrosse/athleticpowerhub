<div>
    <form wire:submit="save" class="space-y-6">
        <div>
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Sets</h3>
                <button type="button" wire:click="addSet" 
                        class="inline-flex items-center px-3 py-1 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Add Set
                </button>
            </div>

            @foreach($sets as $index => $set)
                <div class="bg-gray-50 p-4 rounded-lg mb-4">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-md font-medium text-gray-900">Set {{ $set['set_number'] }}</h4>
                        <div class="flex gap-2">
                            @if($index > 0)
                                <button type="button" wire:click="copySet({{ $index }})" 
                                        class="text-indigo-600 hover:text-indigo-800">
                                    Copy Previous
                                </button>
                            @endif
                            <button type="button" wire:click="removeSet({{ $index }})" 
                                    class="text-red-600 hover:text-red-800">
                                Remove
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div>
                            <label for="sets.{{ $index }}.reps" class="block text-sm font-medium text-gray-700">Reps</label>
                            <input type="number" wire:model="sets.{{ $index }}.reps" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error("sets.{$index}.reps") <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="sets.{{ $index }}.weight" class="block text-sm font-medium text-gray-700">Weight</label>
                            <div class="flex gap-2">
                                <input type="number" step="0.01" wire:model="sets.{{ $index }}.weight" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <input type="text" wire:model="sets.{{ $index }}.weight_unit" 
                                       placeholder="kg/lbs"
                                       class="mt-1 block w-20 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            @error("sets.{$index}.weight") <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="sets.{{ $index }}.rest_duration_after_set" class="block text-sm font-medium text-gray-700">Rest After Set (seconds)</label>
                            <input type="number" wire:model="sets.{{ $index }}.rest_duration_after_set" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error("sets.{$index}.rest_duration_after_set") <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="sets.{{ $index }}.time" class="block text-sm font-medium text-gray-700">Time (Optional)</label>
                            <div class="flex gap-2">
                                <input type="number" step="0.01" wire:model="sets.{{ $index }}.time" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <input type="text" wire:model="sets.{{ $index }}.time_unit" 
                                       placeholder="sec/min"
                                       class="mt-1 block w-20 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            @error("sets.{$index}.time") <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="sets.{{ $index }}.distance" class="block text-sm font-medium text-gray-700">Distance (Optional)</label>
                            <div class="flex gap-2">
                                <input type="number" step="0.01" wire:model="sets.{{ $index }}.distance" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <input type="text" wire:model="sets.{{ $index }}.distance_unit" 
                                       placeholder="m/km/yd/mi"
                                       class="mt-1 block w-20 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            @error("sets.{$index}.distance") <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="md:col-span-2 lg:col-span-3">
                            <label for="sets.{{ $index }}.meta_data" class="block text-sm font-medium text-gray-700">Set Notes (Optional)</label>
                            <textarea wire:model="sets.{{ $index }}.meta_data" 
                                      rows="2"
                                      placeholder="e.g., RPE: 8, Tempo: 31X0, Failure"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                            @error("sets.{$index}.meta_data") <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="border-t pt-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="log_date" class="block text-sm font-medium text-gray-700">Date</label>
                    <input type="date" wire:model="log_date" id="log_date" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('log_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700">Overall Notes (Optional)</label>
                    <textarea wire:model="notes" id="notes" rows="3" 
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                              placeholder="e.g., Felt strong today, slight shoulder pain"></textarea>
                    @error('notes') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <button type="submit" 
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Save Exercise Log
            </button>
        </div>
    </form>
</div>
