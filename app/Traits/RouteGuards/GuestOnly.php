<?php

namespace App\Traits\RouteGuards;

trait GuestOnly {
    public function __construct()
    {
        parent::__construct();

        if ($this->user->isLoggedIn()) {
            $this->redirect('/');
        }
    }
}
