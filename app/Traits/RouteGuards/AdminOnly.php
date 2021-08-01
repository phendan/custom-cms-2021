<?php

namespace App\Traits\RouteGuards;

trait AdminOnly {
    public function __construct()
    {
        parent::__construct();

        if (!$this->user->isLoggedIn() || $this->user->getRole() !== 'admin') {
            $this->redirect('/login');
        }
    }
}
