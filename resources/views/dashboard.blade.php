<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Fitness Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Quick Actions -->
            <div class="mb-6">
                <div class="flex space-x-8">
                    <a href="{{ route('metrics.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Log New Workout
                    </a>
                    <a href="{{ route('exercises.create') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Add New Exercise
                    </a>
                </div>
            </div>

            <!-- Quick Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                @if (!$hasData)
                    <div class="col-span-full">
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                            <div class="p-6 text-center">
                                <div class="mb-4">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No Metrics Yet</h3>
                                <p class="text-gray-500 mb-6">Start tracking your fitness journey by logging your first metric.</p>
                                <div class="space-x-4">
                                    <a href="{{ route('metrics.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Log First Metric
                                    </a>
                                    <a href="{{ route('exercises.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Browse Exercises
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Recent Metrics -->
                    <div class="col-span-full">
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Metrics</h3>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Exercise</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Load</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reps</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sets</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Distance</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Height</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Speed</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($metrics as $metric)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $metric->exercise->name }}
                                                            @if($metric->is_pr)
                                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 ml-2">
                                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                                                    </svg>
                                                                    PR
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">
                                                            {{ str_replace('_', ' ', $metric->metric_type) }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">
                                                            {{ $metric->load ? $metric->load . ' lbs' : '-' }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">
                                                            {{ $metric->reps ?? '-' }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">
                                                            {{ $metric->sets ?? '-' }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">
                                                            {{ $metric->duration ? $metric->duration . ' sec' : '-' }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">
                                                            {{ $metric->distance ? $metric->distance . ' m' : '-' }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">
                                                            {{ $metric->height ? $metric->height . ' in' : '-' }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">
                                                            {{ $metric->speed ? $metric->speed . ' mph' : '-' }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">
                                                            {{ $metric->performed_at ? $metric->performed_at->format('M d, Y') : '-' }}
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Main Content Area -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Activity -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-medium text-gray-900">Recent Activity</h3>
                            <button class="text-sm text-indigo-600 hover:text-indigo-900">View All</button>
                        </div>
                        
                        <!-- Activity Timeline -->
                        <div class="space-y-4">
                            @foreach($recentActivities as $activity)
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 rounded-full bg-{{ $activity['icon_color'] }}-100 flex items-center justify-center">
                                            <svg class="w-4 h-4 text-{{ $activity['icon_color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $activity['icon'] }}" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm text-gray-900">{{ $activity['message'] }}</p>
                                        <p class="text-xs text-gray-500">{{ $activity['date']->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Goals & Targets -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-medium text-gray-900">Goals & Targets</h3>
                            <button class="text-sm text-indigo-600 hover:text-indigo-900">Edit Goals</button>
                        </div>
                        
                        <!-- Goals List -->
                        <div class="space-y-4">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="flex justify-between items-center mb-2">
                                    <h4 class="text-sm font-medium text-gray-900">Bench Press Goal</h4>
                                    <span class="text-sm text-gray-500">225 lbs</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-indigo-600 h-2 rounded-full" style="width: 91%"></div>
                                </div>
                                <p class="text-sm text-gray-600 mt-2">20 lbs remaining</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="flex justify-between items-center mb-2">
                                    <h4 class="text-sm font-medium text-gray-900">40 Yard Dash Goal</h4>
                                    <span class="text-sm text-gray-500">4.5 sec</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-indigo-600 h-2 rounded-full" style="width: 85%"></div>
                                </div>
                                <p class="text-sm text-gray-600 mt-2">0.3 sec remaining</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="flex justify-between items-center mb-2">
                                    <h4 class="text-sm font-medium text-gray-900">Vertical Leap Goal</h4>
                                    <span class="text-sm text-gray-500">36 in</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-indigo-600 h-2 rounded-full" style="width: 89%"></div>
                                </div>
                                <p class="text-sm text-gray-600 mt-2">4 in remaining</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Visualization Section -->
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Progress Visualization</h3>
                        <div class="flex space-x-2">
                            <button class="inline-flex items-center px-3 py-1 bg-gray-100 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 focus:bg-gray-200 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Max Weight
                            </button>
                            <button class="inline-flex items-center px-3 py-1 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Volume
                            </button>
                            <button class="inline-flex items-center px-3 py-1 bg-gray-100 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 focus:bg-gray-200 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Reps
                            </button>
                        </div>
                    </div>

                    <!-- Chart Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Bench Press Progress -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-gray-900 mb-4">Bench Press Progress</h4>
                            <div class="h-48 flex items-end justify-between space-x-1">
                                <div class="flex-1 bg-indigo-600 rounded-t" style="height: 60%">
                                    <div class="text-xs text-white text-center mt-1">180</div>
                                </div>
                                <div class="flex-1 bg-indigo-600 rounded-t" style="height: 65%">
                                    <div class="text-xs text-white text-center mt-1">185</div>
                                </div>
                                <div class="flex-1 bg-indigo-600 rounded-t" style="height: 70%">
                                    <div class="text-xs text-white text-center mt-1">190</div>
                                </div>
                                <div class="flex-1 bg-indigo-600 rounded-t" style="height: 75%">
                                    <div class="text-xs text-white text-center mt-1">195</div>
                                </div>
                                <div class="flex-1 bg-indigo-600 rounded-t" style="height: 80%">
                                    <div class="text-xs text-white text-center mt-1">200</div>
                                </div>
                                <div class="flex-1 bg-indigo-600 rounded-t" style="height: 85%">
                                    <div class="text-xs text-white text-center mt-1">205</div>
                                </div>
                            </div>
                            <div class="flex justify-between mt-2 text-xs text-gray-500">
                                <span>6 months ago</span>
                                <span>Current</span>
                            </div>
                        </div>

                        <!-- 40 Yard Dash Progress -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-gray-900 mb-4">40 Yard Dash Progress</h4>
                            <div class="h-48 flex items-end justify-between space-x-1">
                                <div class="flex-1 bg-green-600 rounded-t" style="height: 85%">
                                    <div class="text-xs text-white text-center mt-1">5.2</div>
                                </div>
                                <div class="flex-1 bg-green-600 rounded-t" style="height: 80%">
                                    <div class="text-xs text-white text-center mt-1">5.0</div>
                                </div>
                                <div class="flex-1 bg-green-600 rounded-t" style="height: 75%">
                                    <div class="text-xs text-white text-center mt-1">4.9</div>
                                </div>
                                <div class="flex-1 bg-green-600 rounded-t" style="height: 70%">
                                    <div class="text-xs text-white text-center mt-1">4.8</div>
                                </div>
                                <div class="flex-1 bg-green-600 rounded-t" style="height: 65%">
                                    <div class="text-xs text-white text-center mt-1">4.7</div>
                                </div>
                                <div class="flex-1 bg-green-600 rounded-t" style="height: 60%">
                                    <div class="text-xs text-white text-center mt-1">4.8</div>
                                </div>
                            </div>
                            <div class="flex justify-between mt-2 text-xs text-gray-500">
                                <span>6 months ago</span>
                                <span>Current</span>
                            </div>
                        </div>

                        <!-- Vertical Leap Progress -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-gray-900 mb-4">Vertical Leap Progress</h4>
                            <div class="h-48 flex items-end justify-between space-x-1">
                                <div class="flex-1 bg-blue-600 rounded-t" style="height: 65%">
                                    <div class="text-xs text-white text-center mt-1">28</div>
                                </div>
                                <div class="flex-1 bg-blue-600 rounded-t" style="height: 70%">
                                    <div class="text-xs text-white text-center mt-1">29</div>
                                </div>
                                <div class="flex-1 bg-blue-600 rounded-t" style="height: 75%">
                                    <div class="text-xs text-white text-center mt-1">30</div>
                                </div>
                                <div class="flex-1 bg-blue-600 rounded-t" style="height: 80%">
                                    <div class="text-xs text-white text-center mt-1">31</div>
                                </div>
                                <div class="flex-1 bg-blue-600 rounded-t" style="height: 85%">
                                    <div class="text-xs text-white text-center mt-1">32</div>
                                </div>
                                <div class="flex-1 bg-blue-600 rounded-t" style="height: 90%">
                                    <div class="text-xs text-white text-center mt-1">32</div>
                                </div>
                            </div>
                            <div class="flex justify-between mt-2 text-xs text-gray-500">
                                <span>6 months ago</span>
                                <span>Current</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
