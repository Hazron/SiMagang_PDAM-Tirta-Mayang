<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rules;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class setPasswordController extends Controller
{
    public function magangView()
    {
        $userMagang = auth()->user();
        $userMagang = User::where('id', $userMagang->id)->first();
        return view('magang.page.magang-password', compact('userMagang'));
    }

    public function updatePasswordMagang(Request $request)
    {
        $request->validate([
            'password' => ['required'],
            'new_password' => ['required', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'password' => 'Password lama yang Anda masukkan salah.',
            ]);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Password berhasil diperbarui.');
    }
}

