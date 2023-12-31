<?php

use Illuminate\Support\Facades\Auth;

function userRoleName(){
    return auth()->guard('admin')->user()->getRoleNames()->first();
}


function hasPermission(array $permission){
    if(userRoleName()==='Super Admin'){
        return true;
    }else{
        return auth()->guard('admin')->user()->hasAnyPermission($permission);
    }
}


function generateRandomString(){
    $key = random_int(0, 999999);
    $key = str_pad($key, 6, 0, STR_PAD_LEFT);
    return $key;
}

function LoggedAdmin(){
    return Auth::guard('admin')->user();
}