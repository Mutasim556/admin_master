<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HandleLoginRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkIfLoggedIn')->only(['login','handleLogin']);
    }
    public function login() : View {
        return view('backend.auth.login');
    }

    public function handleLogin(HandleLoginRequest $data) : RedirectResponse {
        try {
            if($data->authenticate()){
                return to_route('admin.index')->with('success_login',1);
            }else{
                return back()->with('invalid_login', 1);
            }
        } catch (\Throwable $th) {
            return response(['status' => 'error', 'message' => __('admin_local.Someting went wrong!')]);
        }
    }

    public function index() : View{
        return view('backend.blade.dashboard.index');
    }

    public function handleLogout() : RedirectResponse {
        try {
            Auth::guard('admin')->logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
            return to_route('admin.login');
        } catch (\Throwable $th) {
            return response(['status' => 'error', 'message' => __('admin_local.Someting went wrong!')]);
        }
    }
}
