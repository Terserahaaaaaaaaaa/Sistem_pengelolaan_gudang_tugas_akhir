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

    public function aktifkan(User $user)
    {
        $user->update([
            'status' => 'aktif'
        ]);

        return back()->with(
            'success',
            'User berhasil diaktifkan.'
        );
    }

    public function nonaktifkan(User $user)
    {
        $user->update([
            'status' => 'nonaktif'
        ]);

        return back()->with(
            'success',
            'User berhasil dinonaktifkan.'
        );
    }

    public function show(User $user)
{
    return view('user.show', compact('user'));
}

public function destroy(User $user)
{
    if ($user->role == 'admin') {

        return back()->with(
            'error',
            'Admin tidak dapat dihapus.'
        );
    }

    $user->delete();

    return back()->with(
        'success',
        'User berhasil dihapus.'
    );
}
}