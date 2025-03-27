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
                <div class="flex space-x-4">
                    <button class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Log New Workout
                    </button>
                    <button class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Add New Exercise
                    </button>
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
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No Personal Records Yet</h3>
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
                    <!-- Bench Press PR -->
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-red-100 text-red-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-sm font-medium text-gray-600">Bench Press 5RM</h2>
                                <p class="text-lg font-semibold text-gray-900">
                                    {{ $benchPressPR ? $benchPressPR->formatted_value : 'No data' }}
                                </p>
                                @if(isset($monthlyChanges[$benchPressPR->exercise_id]))
                                    <div class="flex items-center text-sm {{ $monthlyChanges[$benchPressPR->exercise_id]['value'] > 0 ? 'text-green-600' : 'text-red-600' }}">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $monthlyChanges[$benchPressPR->exercise_id]['value'] > 0 ? 'M5 10l7-7m0 0l7 7m-7-7v18' : 'M19 14l-7 7m0 0l-7-7m7 7V3' }}" />
                                        </svg>
                                        <span>{{ abs($monthlyChanges[$benchPressPR->exercise_id]['value']) }} {{ $monthlyChanges[$benchPressPR->exercise_id]['unit'] }} from last month</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- 40 Yard Dash -->
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-sm font-medium text-gray-600">40 Yard Dash</h2>
                                <p class="text-lg font-semibold text-gray-900">
                                    {{ $sprintPR ? $sprintPR->formatted_value : 'No data' }}
                                </p>
                                @if(isset($monthlyChanges[$sprintPR->exercise_id]))
                                    <div class="flex items-center text-sm {{ $monthlyChanges[$sprintPR->exercise_id]['value'] < 0 ? 'text-green-600' : 'text-red-600' }}">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $monthlyChanges[$sprintPR->exercise_id]['value'] < 0 ? 'M5 10l7-7m0 0l7 7m-7-7v18' : 'M19 14l-7 7m0 0l-7-7m7 7V3' }}" />
                                        </svg>
                                        <span>{{ abs($monthlyChanges[$sprintPR->exercise_id]['value']) }} {{ $monthlyChanges[$sprintPR->exercise_id]['unit'] }} from last month</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Vertical Leap -->
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-green-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-sm font-medium text-gray-600">Vertical Leap</h2>
                                <p class="text-lg font-semibold text-gray-900">
                                    {{ $verticalLeapPR ? $verticalLeapPR->formatted_value : 'No data' }}
                                </p>
                                @if(isset($monthlyChanges[$verticalLeapPR->exercise_id]))
                                    <div class="flex items-center text-sm {{ $monthlyChanges[$verticalLeapPR->exercise_id]['value'] > 0 ? 'text-green-600' : 'text-red-600' }}">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $monthlyChanges[$verticalLeapPR->exercise_id]['value'] > 0 ? 'M5 10l7-7m0 0l7 7m-7-7v18' : 'M19 14l-7 7m0 0l-7-7m7 7V3' }}" />
                                        </svg>
                                        <span>{{ abs($monthlyChanges[$verticalLeapPR->exercise_id]['value']) }} {{ $monthlyChanges[$verticalLeapPR->exercise_id]['unit'] }} from last month</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Agility Time -->
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-sm font-medium text-gray-600">Agility Time</h2>
                                <p class="text-lg font-semibold text-gray-900">
                                    {{ $agilityPR ? $agilityPR->formatted_value : 'No data' }}
                                </p>
                                @if(isset($monthlyChanges[$agilityPR->exercise_id]))
                                    <div class="flex items-center text-sm {{ $monthlyChanges[$agilityPR->exercise_id]['value'] < 0 ? 'text-green-600' : 'text-red-600' }}">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $monthlyChanges[$agilityPR->exercise_id]['value'] < 0 ? 'M5 10l7-7m0 0l7 7m-7-7v18' : 'M19 14l-7 7m0 0l-7-7m7 7V3' }}" />
                                        </svg>
                                        <span>{{ abs($monthlyChanges[$agilityPR->exercise_id]['value']) }} {{ $monthlyChanges[$agilityPR->exercise_id]['unit'] }} from last month</span>
                                    </div>
                                @endif
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
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm text-gray-900">Logged new Bench Press PR: 205 lbs x 5 reps</p>
                                    <p class="text-xs text-gray-500">2 hours ago</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm text-gray-900">Improved 40-yard dash time to 4.8 seconds</p>
                                    <p class="text-xs text-gray-500">Yesterday</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm text-gray-900">Completed leg day workout</p>
                                    <p class="text-xs text-gray-500">2 days ago</p>
                                </div>
                            </div>
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
