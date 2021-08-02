<?php

namespace App\Traits\RouteGuards;

trait AdminOrAuthor {
    public function __construct()
    {
        parent::__construct();

        if (!$this->user->isLoggedIn() || ($this->user->getRole() !== 'admin' && $this->user->getRole() !== 'author')) {
            $this->redirect('/');
        }
    }
}
