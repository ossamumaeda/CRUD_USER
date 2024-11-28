<?php

namespace App\Service;

class UserService
{
    protected $session;
    protected $key = "user_key_2";
    function __construct($app_session)
    {   
        $this->session = $app_session;
    }

    // private $users = $this->session->get('teste', []) ?? ['Alice', 'Bob', 'Charlie'];

    public function getAllUsers()
    {   
        $r = $this->session->get($this->key, []);
        return $r;
    }

    public function registerUser($username,$email,$password){
        $users = $this->session->get($this->key, []);
        if(!$users){
            return $this->session->set($this->key, [[
                'username' => $username,
                'email' => $email,
                'password' => $password
            ]]);
        }
        $users[] = [
            'username' => $username,
            'email' => $email,
            'password' => $password
        ];
        $this->session->set($this->key, $users);
        return $users;
    }
}
