<?php

namespace App\Http\Controllers;

use App\Models\User;

class AdminsController
{

    public function index()
    {
        // simple authentication function
        if (auth()->user()->role !== 1) {
            auth()->logout();
            return redirect()->route('login');
        }

        $users = User::paginate(10);

        return view('admin.home')->with('users', $users);
    }
}