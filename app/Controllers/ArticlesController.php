<?php

namespace App\Controllers;

use App\Interfaces\BaseController;
use App\Request;
use App\Models\Article;

class ArticlesController extends BaseController {
    public function index(Request $request)
    {
        if (!$request->hasInput()) {
            return $this->renderView('articles/index');
        }

        [$slug] = $request->getInput();
        $article = new Article($this->db);

        if (!$article->find($slug)) {
            return $this->redirect('/articles');
        }

        if ($request->expectsJson()) {
            $this->renderJson(200, [
                'article' => $article->getArray()
            ]);
        }

        $this->renderView('articles/slug', [
            'article' => $article
        ]);
    }
}
