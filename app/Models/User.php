<?php

namespace App\Models;

use Exception;

class User {
    private $db;
    private $id;
    private $email;
    private $first_name;
    private $last_name;
    private $password;
    private $joined;

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

        $_SESSION['userId'] = $this->id;
    }

    public function getId()
    {
        return $this->id;
    }
}
