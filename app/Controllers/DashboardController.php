<?php

namespace App\Controllers;

use App\Interfaces\BaseController;
use App\Models\Session;
use App\Request;
use App\Traits\RouteGuards\UserOnly;

class DashboardController extends BaseController {
    use UserOnly;

    public function index(Request $request)
    {
        // var_dump($this->user->getRole());
        // echo '<pre>', var_dump($this->user), '</pre>';
        if ($this->user->getRole() === 'admin') {
            $allUsers = $this->db->table('users')->getAll();
            return $this->renderView('dashboard', [
                'allUsers' => $allUsers
            ]);
        }

        $this->renderView('dashboard');
    }
}
