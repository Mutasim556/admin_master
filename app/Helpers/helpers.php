<?php

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