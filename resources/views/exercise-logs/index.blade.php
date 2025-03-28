<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Exercise History') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session()->has('message'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('message') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($exerciseLogs->isEmpty())
                        <p class="text-gray-500 text-center">No exercise logs found. Start by logging an exercise!</p>
                    @else
                        <div class="space-y-6">
                            @foreach($exerciseLogs as $log)
                                <div class="border rounded-lg p-4 relative">
                                    <div class="absolute -left-3 top-4 w-2 h-2 bg-indigo-600 rounded-full"></div>
                                    @if(!$loop->last)
                                        <div class="absolute -left-3 top-6 w-0.5 h-full bg-gray-200"></div>
                                    @endif
                                    
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <h3 class="text-lg font-semibold">{{ $log->exercise->name }}</h3>
                                                <span class="text-sm text-gray-500">{{ $log->log_date->format('F j, Y') }}</span>
                                            </div>
                                        </div>
                                        <a href="{{ route('exercises.index') }}" 
                                           class="inline-flex items-center px-3 py-1 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            Log New Exercise
                                        </a>
                                    </div>

                                    @if($log->notes)
                                        <p class="text-sm text-gray-600 mb-4">{{ $log->notes }}</p>
                                    @endif

                                    <div class="space-y-2">
                                        @foreach($log->setEntries as $set)
                                            <div class="bg-gray-50 p-3 rounded">
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <span class="font-medium">Set {{ $set->set_number }}:</span>
                                                        @if($set->reps)
                                                            <span>{{ $set->reps }} reps</span>
                                                        @endif
                                                        @if($set->weight)
                                                            <span>{{ $set->weight }} {{ $set->weight_unit }}</span>
                                                        @endif
                                                        @if($set->time)
                                                            <span>{{ $set->time }} {{ $set->time_unit }}</span>
                                                        @endif
                                                        @if($set->distance)
                                                            <span>{{ $set->distance }} {{ $set->distance_unit }}</span>
                                                        @endif
                                                        @if($set->rest_duration_after_set)
                                                            <span class="text-gray-500">(Rest: {{ $set->rest_duration_after_set }}s)</span>
                                                        @endif
                                                    </div>
                                                    @if($set->meta_data)
                                                        <div class="text-sm text-gray-500">
                                                            {{ json_decode($set->meta_data)->notes }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 