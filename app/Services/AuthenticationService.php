<?php

namespace App\Services;


class AuthenticationService{


    function validateUser(){
        return [
            'member_id' => 'required|string',
            'club_id'   => 'required|integer',
            'password'  => 'required|string|min:6',
        ];
    }
}
