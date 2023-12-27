<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminLoginController extends Controller
{
    public function login() : View {
        return view('backend.auth.login');
    }

    public function handleLogin(Request $data) : RedirectResponse {
        
        return to_route('admin.index');
    }
}
