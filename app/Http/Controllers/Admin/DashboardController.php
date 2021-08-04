<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'users_count' => User::count(),
            'patients_count' => Patient::count(),
        ]);
    }
}
