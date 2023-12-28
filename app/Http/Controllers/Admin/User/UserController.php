<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    /**
     * Contruct method
     */
    public function __construct()
    {
        $this->middleware(['permission:user-index,admin'])->only('index');
        $this->middleware(['permission:user-create,admin'])->only('store');
        $this->middleware(['permission:user-update,admin'])->only(['edit','update','updateStatus']);
        $this->middleware(['permission:user-delete,admin'])->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = Admin::where('delete','0')->get();
        $roles = Role::all();
        return view('backend.blade.user.index',compact('users','roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    
    public function updateStatus(Request $data){
        try {
            $user = Admin::findOrfail($data->id);
            $user->status = $data->status;
            $user->updated_at = Carbon::now();
            $user->save();
            return $user;
        } catch (\Throwable $th) {
            return response(['status' => 'error', 'message' => __('admin_local.Someting went wrong!')]);
        }
    }
}
