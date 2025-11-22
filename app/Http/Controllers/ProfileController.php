<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        return view('admin.profile');
    }

    public function update(Request $request)
    {
        $user = Auth::guard('admin')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|min:6'
        ]);

        $user->name = $request->name;

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return back()->with('success', 'Perfil actualizado correctamente.');
    }
}
