<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Recipe Preferences') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your recipe preferences.") }}
        </p>
    </header>

    <form method="post" action="{{ route('user-preference.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="spice_level" :value="__('Spice Level')" />
            <em>Hint: Spicy or Mild</em>
            <select id="spice_level" name="spice_level" class="mt-1 rounded block w-full" required autocomplete="spice_level">
                <option value="" disabled selected>Select your spice level</option>
                <option value="Spicy" {{ old('spice_level', $user->preference->spice_level) == 'Spicy' ? 'selected' : '' }}>Spicy</option>
                <option value="Mild" {{ old('spice_level', $user->preference->spice_level) == 'Mild' ? 'selected' : '' }}>Mild</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('spice_level')" />
        </div>

        <div>
            <x-input-label for="price_range" :value="__('Price Range')" />
            <em>Hint: Affordable, Very Expensive, Moderate, or Moderate-Expensive</em>
            <select id="price_range" name="price_range" class="mt-1 rounded block w-full" required autocomplete="price_range">
                <option value="" disabled selected>Select your price range</option>
                <option value="Affordable" {{ old('price_range', $user->preference->price_range) == 'Affordable' ? 'selected' : '' }}>Affordable</option>
                <option value="Moderate" {{ old('price_range', $user->preference->price_range) == 'Moderate' ? 'selected' : '' }}>Moderate</option>
                <option value="Moderate-Expensive" {{ old('price_range', $user->preference->price_range) == 'Moderate-Expensive' ? 'selected' : '' }}>Moderate-Expensive</option>
                <option value="Very Expensive" {{ old('price_range', $user->preference->price_range) == 'Very Expensive' ? 'selected' : '' }}>Very Expensive</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('price_range')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
