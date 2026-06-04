<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();

        return view('user.index', compact('users'));
    }

    public function approve(User $user)
    {
        $user->update([
            'status' => 'aktif'
        ]);

        return back()->with(
            'success',
            'User berhasil disetujui.'
        );
    }

    public function reject(User $user)
    {
        $user->update([
            'status' => 'ditolak'
        ]);

        return back()->with(
            'success',
            'User berhasil ditolak.'
        );
    }
}
