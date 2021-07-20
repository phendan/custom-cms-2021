<?php

namespace App\Controllers;

use App\Models\Database;
use App\Models\User;

class ProfileController {
    public function index($id = null)
    {
        $db = new Database;
        $user = new User($db);
        $user->find($id);

        echo '<pre>', var_dump($user->getId()), '</pre>';
    }
}
