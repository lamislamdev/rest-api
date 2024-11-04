<?php

namespace App\Helper;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTToken
{

//    Encode the email or id to JWT Token .
//    Token Valid for 1 hours !
  public static function encode($email, $id)
    {
        $key = env('JWT_KEY');
        $payload = [
            'iss'   =>'localhost',
            'iat'   =>time(),
            'exp'   =>time() + 3600,
            'email' =>$email,
            'id'    =>$id
        ];
        return JWT::encode($payload, $key , "HS256");
    }

//    JWT Token decode To email or id
  public static function decode($token){
        $key = env('JWT_KEY');
        return JWT::decode($token, new Key($key, 'HS256'));
    }

}
