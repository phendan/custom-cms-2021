<?php

namespace App\Models;

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
        }
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

        var_dump($userData);

        // insert into DB
    }

    public function getId()
    {
        return $this->id;
    }
}
