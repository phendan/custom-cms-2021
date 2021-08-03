<?php

namespace App\Models;

use Exception;
use App\Models\User;
use App\Models\Str;
use App\Models\Database;

class Article {
    private $db;
    private $id;
    private $title;
    private $slug;
    private $body;
    private $created;
    private $author_id;
    private $image;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function find($identifier)
    {
        $field = is_numeric($identifier) ? 'id' : 'slug';
        // $articleQuery = $this->db->table('articles')->where($field, '=', $identifier);
        $articleQuery = $this->db->query("SELECT * FROM articles LEFT JOIN articles_images ON articles_images.article_id = articles.id WHERE {$field} = ?", [ $identifier ]);

        if ($articleQuery->count()) {
            $articleData = $articleQuery->first();

            foreach ($articleData as $field => $value) {
                $this->{$field} = $value;
            }

            return true;
        }

        return false;
    }

    public function create($userId, $title, $body, $image = null)
    {
        $slug = Str::slug($title);
        $articleData = [
            'title' => $title,
            'slug' => $slug,
            'body' => $body,
            'created' => time(),
            'author_id' => $userId
        ];

        $this->db->table('articles')->store($articleData);

        if (!isset($image)) return;

        $this->find($slug);
        $fileStorage = new FileStorage($image);
        try {
            $fileStorage->saveIn('images');
            $imageReference = $fileStorage->getGeneratedName();

            $this->db->table('articles_images')->store([
               'article_id' => $this->id,
               'image' => $imageReference
            ]);
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getCreated()
    {
        return date('D, d.m.y H:i:s', $this->created);
    }

    public function getAuthor()
    {
        $user = new User($this->db);
        $user->find($this->author_id);
        return $user;
    }

    public function getImage()
    {
        return $this->image;
    }
}
