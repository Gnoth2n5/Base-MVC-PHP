<?php

namespace App\Core;
use App\Models\User;

class Auth{
    public static function user(){
        return $_SESSION['user'] ?? null;
    }

    public static function check(){
        return isset($_SESSION['user']);
    }

    public static function attempt($email, $password){
        $user = User::where('email', $email);
        if(!$user){
            return false;
        }
        if(password_verify($password, $user->password)){
            $_SESSION['user'] = $user->id;
            return true;
        }
        return false;
    }

    public static function logout(){
        unset($_SESSION['user']);
    }

}