<?php

require_once '../app/Models/Database.php';

class HomeController {
    public function index()
    {
        $db = new Database;

        // $userQuery = $db->table('users')->where('id', '=', 1);
        // if ($userQuery->count()) {
        //     //
        // }
    }
}
