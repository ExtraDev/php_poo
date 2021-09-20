<?php

namespace App\Models;

class Tag extends Model{
    
    protected $table = 'tags';
    
    public function getPosts() {
        return $this->query("SELECT *
        FROM posts
        INNER JOIN post_tag ON post_tag.id_post = posts.id_post
        WHERE post_tag.id_tag = ?",
            $this->id_tag
        );
    }

    public function getById(int $id): Tag{
        return $this->query("SELECT * FROM {$this->table} WHERE id_tag = ?",  $id, true);
    }
}