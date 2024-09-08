<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Welcome to our Smart Recipe Recommendation App!") }}

                    <!-- Button to generate recipe -->
                    <form method="post" action="{{ route('generate-recipe') }}" class="mt-6">
                        @csrf
                        <x-primary-button>
                            {{ __('Generate Recipe') }}
                        </x-primary-button>
                    </form>

                    <!-- Display the generated recipe if available -->
                    @if (isset($recipe))
                        <div class="mt-6">
                            <h3 class="text-lg font-semibold">Generated Recipe:</h3>
                            <p><strong>Name:</strong> {{ $recipe['food_name'] }}</p>
                            <p><strong>Spice Level:</strong> {{ $recipe['spice_level'] }}</p>
                            <p><strong>Price Range:</strong> {{ $recipe['price_range'] }}</p>
                            <p><strong>Ingredients:</strong></p>
                            <!-- Display ingredients as a list -->
                            <ul>
                                @foreach (explode(', ', $recipe['main_ingredients']) as $ingredient)
                                    <li>{{ $ingredient }}</li>
                                @endforeach
                            </ul>
                            <p><strong>Description:</strong> {{ $recipe['description'] }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
