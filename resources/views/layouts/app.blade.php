<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts

        <script>
            document.addEventListener('livewire:initialized', () => {
                console.log('Livewire initialized');
                
                Livewire.on('prefill-metric', (event) => {
                    console.log('Received prefill-metric event:', event);
                    const data = event[0]; // Get the first item from the array
                    
                    // Pre-fill all form fields
                    Object.keys(data).forEach(key => {
                        const input = document.getElementById(key);
                        console.log(`Looking for input with id ${key}:`, input);
                        if (input) {
                            input.value = data[key] || '';
                            console.log(`Set value for ${key}:`, input.value);
                            // Trigger input event to ensure any dependent calculations are updated
                            input.dispatchEvent(new Event('input', { bubbles: true }));
                        }
                    });

                    // If exercise_id is provided, update the exercise search input
                    if (data.exercise_id) {
                        const exerciseSearch = document.getElementById('exercise_search');
                        console.log('Found exercise search input:', exerciseSearch);
                        if (exerciseSearch) {
                            exerciseSearch.value = data.exercise_name || '';
                            console.log('Set exercise name:', data.exercise_name);
                            // Trigger the search update
                            exerciseSearch.dispatchEvent(new Event('input', { bubbles: true }));
                        }
                    }
                });
            });
        </script>
    </body>
</html>
