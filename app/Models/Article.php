<?php

namespace App\Models;

class Article
{
    public function construct()
    {
    }

    public function find($identifier)
    {
        $field = is_numeric($identifier) ? 'id' : 'slug';
        // $userQuery = $this->db->table('articles')->where($field, '=', $identifier);
        $userQuery = $this->db->table('articles')
            ->join('articles_images', ['articles.image_id', 'articles_images.id'])
            ->where($field, '=', $identifier);

        $userQuery = $this->db->table('articles')
            ->join('articles_images')->on('image_id', 'id')
            ->where($field, '=', $identifier);

        if ($userQuery->count()) {
            $userData = $userQuery->first();

            foreach ($userData as $field => $value) {
                $this->{$field} = $value;
            }

            return true;
        }

        return false;
    }
}
