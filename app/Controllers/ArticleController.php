<?php

namespace App\Controllers;

use App\Interfaces\BaseController;
use App\Request;

class ArticleController extends BaseController {
    public function index(Request $request)
    {
        if (!$request->hasInput()) {
            $this->redirect('/');
        }

        [ $id, $slug ] = $request->getInput();
        var_dump($id, $slug);
    }

    public function create(Request $request)
    {

    }
}
