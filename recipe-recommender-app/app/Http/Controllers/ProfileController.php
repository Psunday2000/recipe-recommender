<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Models\UserPreference;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

use function Laravel\Prompts\error;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }
    
    /**
     * Update the user's preference information.
     */
    public function updatePreference(Request $request): RedirectResponse
    {
        // Validate the request data
        $request->validate([
            'spice_level' => 'required|string',
            'price_range' => 'required|string',
        ]);

        $spice_level = $request->input('spice_level');
        $price_range = $request->input('price_range');

        $user = Auth::user();

        // Find or create the user preference
        $user_preference = $user->preference->first();
        
        if (!$user_preference) {
            $user_preference = new UserPreference();
            $user_preference->user_id = $user->id;
        }

        // Update the preference
        $user_preference->spice_level = $spice_level;
        $user_preference->price_range = $price_range;
        $user_preference->save();

        return Redirect::route('profile.edit')->with('status', 'preferences-updated');
    }

    /**
     * Generate a recipe based on user preferences.
     */
    public function generateRecipe(Request $request)
    {
        // Get the authenticated user and their preferences
        $user = Auth::user();
        $preferences = $user->preference;

        // Send a POST request to the Flask API to generate a recipe
        $response = Http::post('http://localhost:5000/generate-recipe', [
            'spice_level' => $preferences->spice_level,
            'price_range' => $preferences->price_range,
        ]);

        // Check if the request was successful
        if ($response->successful()) {
            // Extract the recipe details from the response
            $recipe = $response->json();

            // Return the recipe data directly to the view
            return view('dashboard', ['recipe' => $recipe]);
        } else {
            // Return the dashboard view with an error message
            return view('dashboard')->with(error('Failed to generate a recipe.'));
        }
    }



    
    /**
     * Show the user's preference information.
     */
    public function showPreference(User $user)
    {
        $user_preference = $user->preference()->get();

        return route('user-preference', compact('user_preference'));
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
