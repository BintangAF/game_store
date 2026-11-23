<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();

        return view('profile.show', [
            'user' => $user,
            'library' => LibraryController::libraryFor($user->user_id),
            'orders' => \App\Models\Order::with('items.game')->where('user_id', $user->user_id)->latest()->get(),
        ]);
    }

    public function edit()
    {
        return view('profile.edit', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'username' => ['required', 'string', 'max:40', Rule::unique('users', 'username')->ignore($user->user_id, 'user_id')],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->user_id, 'user_id')],
        ]);

        $user->update($data);

        return redirect()->route('profile')->with('status', 'Profil diperbarui.');
    }
}
