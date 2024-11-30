<?php

namespace App\Controllers;
use App\Models\UserModel;

class AdminController extends BaseController{
    public function dashboard(){
        
        return view('includes/header');;
    }
}