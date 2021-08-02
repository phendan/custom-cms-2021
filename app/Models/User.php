<?php

namespace App\Models;

use Exception;
use App\Models\Session;

class User {
    private $db;
    private $id;
    private $email;
    private $first_name;
    private $last_name;
    private $password;
    private $joined;
    private $role_id;
    private $role;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function find($identifier)
    {
        $field = is_numeric($identifier) ? 'id' : 'email';
        $userQuery = $this->db->table('users')->where($field, '=', $identifier);

        if ($userQuery->count()) {
            $userData = $userQuery->first();

            foreach ($userData as $field => $value) {
                $this->{$field} = $value;
            }

            return true;
        }

        return false;
    }

    public function register($firstName, $lastName, $email, $password)
    {
        $userData = [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'joined' => time()
        ];

        $this->db->table('users')->store($userData);
    }

    public function login($email, $password)
    {
        if (!$this->find($email)) {
            throw new Exception('Email or password was not correct.');
        }

        if (!password_verify($password, $this->password)) {
            throw new Exception('Email or password was not correct.');
        }

        Session::set('userId', $this->id);
    }

    public function isLoggedIn()
    {
        return Session::exists('userId');
    }

    public function getRole()
    {
        if (isset($this->role)) {
            return $this->role;
        }

        $this->role = $this->db->table('roles')->where('id', '=', $this->role_id)->first()['name'];
        return $this->role;
    }

    public function logout()
    {
        Session::delete('userId');
    }

    public function getId()
    {
        return $this->id ?? Session::get('userId');
    }

    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
