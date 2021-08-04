<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Show the auth user profile.
     */
    public function profile()
    {
        $user = auth()->user();

        return view('users.profile', compact('user'));
    }

    /**
     * Update the user's personal data.
     */
    public function updateData(Request $request)
    {
        $id = auth()->id();
        $data = $request->validate([
            'name' => 'required|string|min:3',
            'phone' => 'required|numeric|unique:users,phone,'.$id,
            'email' => 'required|email|unique:users,email,'.$id,
            'address' => 'required|string',
        ]);

        auth()->user()->update($data);

        success(__('flashes.update'));
        return redirect()->route('user.profile');
    }

    /**
     * Update the user's photo.
     */
    public function updatePhoto(Request $request)
    {
        $data = $request->validate(['photo' => 'required|image']);
        try {
            DB::transaction(function () use($data) {
                $name = storeFile('photo', 'users/images');
                $data['photo'] = $name;
                $user = auth()->user();
                $user->deletePhotoFromUploads();
                $user->update($data);
                success(__('flashes.update'));
            });
        } catch (\Throwable $th) {
            error(__('flashes.error'));
        }
        return redirect()->route('user.profile');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $data = $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed'
        ]);
        
        $user = auth()->user();
        if (Hash::check($data['old_password'], $user->password)) {
            $user->update(['password' => Hash::make($data['new_password'])]);
            success(__('flashes.update'));
        }else {
            error(__('auth.password'));
        }

        return redirect()->route('user.profile');
    }
}
