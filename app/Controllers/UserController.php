<?php

namespace App\Controllers;
use App\Core\BaseController;
use App\Models\User;

class UserController extends BaseController
{
    public function index()
    {
        $users = User::all();
        
    }

}