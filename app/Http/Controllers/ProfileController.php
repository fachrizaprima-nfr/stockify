<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'current_password'      => ['nullable', 'required_with:new_password'],
            'new_password'          => ['nullable', 'min:8', 'confirmed'],
        ], [
            'name.required'             => 'Nama lengkap wajib diisi.',
            'email.required'            => 'Email wajib diisi.',
            'email.unique'              => 'Email ini sudah digunakan oleh akun lain.',
            'current_password.required_with' => 'Kata sandi lama wajib diisi untuk mengganti kata sandi baru.',
            'new_password.min'          => 'Kata sandi baru minimal 8 karakter.',
            'new_password.confirmed'    => 'Konfirmasi kata sandi baru tidak cocok.',
        ]);

        // Verifikasi password lama jika ingin mengganti password baru
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Kata sandi lama yang dimasukkan keliru.'])->withInput();
            }

            $user->password = Hash::make($request->new_password);
        }

        $user->name  = $validated['name'];
        $user->email = $validated['email'];
        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profil dan kata sandi berhasil diperbarui.');
    }
}