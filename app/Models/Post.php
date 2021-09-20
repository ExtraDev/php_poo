<?php

namespace App\Models;

use DateTime;

class Post extends Model{
    
    protected $table = 'posts';
    
    public function getCreatedAt() {
        return (new DateTime($this->created_at))->format("d/m/Y à H:m");
    }

    public function getExcerpt(): string {
        return substr($this->content, 0, 200)."...";
    }

    public function getButton(): string {
        return <<<HTML
        <a href="/posts/$this->id_post" class="btn btn-primary">Lire l'article</a>
HTML;
    }

    public function getTags() {
        return $this->query("SELECT t.* FROM tags t
            INNER JOIN post_tag pt ON pt.id_tag = t.id_tag
            WHERE pt.id_post = ?",
            $this->id_post
        );
    }

    public function getById(int $id): Post{
        return $this->query("SELECT * FROM {$this->table} WHERE id_post = ?",  $id, true);
    }
}