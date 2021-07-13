<?php

namespace App\Models;

class User {
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function find($identifier)
    {
        $field = is_numeric($identifier) ? 'id' : 'email';
        $userQuery = $this->db->table('users')->where($field, '=', $identifier);
    }
}
