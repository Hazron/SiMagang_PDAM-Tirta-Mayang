<?php

namespace App\Http\Controllers\Magang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class profileMagangController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $user = User::where('id', $user->id)->first();

        return view('magang.page.magang-profile', compact('user'));
    }

    public function updatefotoProfile(Request $request)
    {
        $request->validate([
            'fotoprofile' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = auth()->user();
        if ($request->hasFile('fotoprofile')) {
            $file = $request->file('fotoprofile');
            $filename = time() . '_' . $user->name . '_' . $file->getClientOriginalName();

            if ($user->fotoprofile && file_exists(public_path('profilePicture/' . $user->fotoprofile))) {
                unlink(public_path('profilePicture/' . $user->fotoprofile));
            }

            $file->move(public_path('profilePicture'), $filename);
            $user->fotoprofile = $filename;
        }
        $user->save();
        session()->flash('success', 'Foto Profile berhasil diupdate');
        return redirect()->back()->withInput();
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'asal_kampus' => 'required|string|max:255',
            'no_telpon' => 'required|string|max:13',
            'alamat' => 'required|string|max:255',
        ]);

        $user = auth()->user();
        $user->name = $request->name;
        $user->asal_kampus = $request->asal_kampus;
        $user->no_telpon = $request->no_telpon;
        $user->alamat = $request->alamat;
        $user->save();

        session()->flash('success', 'Profile berhasil diupdate');
        return redirect()->back()->withInput();
    }
}
