<?php

namespace App\Controllers;

use App\Request;
use App\Models\Article;
use App\Interfaces\BaseController;
use App\Models\FileValidation;
use App\Models\FormValidation;
use App\Traits\RouteGuards\AdminOrAuthor;

class WriteController extends BaseController {
    use AdminOrAuthor;

    public function index(Request $request)
    {
        if (!$request->hasInput()) {
            $this->renderView('write');
        }

        $formData = $request->getInput();
        $formValidation = new FormValidation($this->db, $formData);
        $formValidation->setRules([
            'title' => 'required|min:10|max:255|available:articles',
            'body' => 'required|min:100'
        ]);
        $formValidation->validate();

        $fileValidation = new FileValidation($formData);
        $fileValidation->setRules([
            'image' => 'required|type:image|maxsize:2097152'
        ]);
        $fileValidation->validate();

        if ($formValidation->fails() || $fileValidation->fails()) {
            return $this->renderView('write', [
                'errors' => array_merge(
                    $formValidation->getErrors(),
                    $fileValidation->getErrors()
                )
            ]);
        }

        $article = new Article($this->db);
        $article->create($this->user->getId(), ...$request->only('title', 'body', 'image'));
        $this->redirect('/');
    }
}
