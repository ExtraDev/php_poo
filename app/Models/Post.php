<?php

namespace App\Models;

use DateTime;

class Post extends Model{
    
    protected $table = 'posts';
    
    public function getCreatedAt() {
        return (new DateTime($this->created_at))->format("d/m/Y à H:i");
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
            [$this->id_post]
        );
    }

    public function getById(int $id): Post{
        return $this->query("SELECT * FROM {$this->table} WHERE id_post = ?",  [$id], true);
    }

    public function destroy(int $id_post):bool {
        $this->isAdmin();
        $this->query("DELETE FROM post_tag WHERE id_post = ?", $id_post);
        return $this->query("DELETE FROM {$this->table} WHERE id_post = ?", [$id_post]);
    }

    // public function update(int $id_post, array $post_data) {
    //     $sqlRequestPart = "";
    //     $i = 1;

    //     foreach ($post_data as $key => $value) {
    //         $commat = $i === count($post_data) ? " " : ', ';
    //         $sqlRequestPart .= "{$key} = :{$key}{$commat}";
    //         $i++;
    //     }

    //     $post_data['id_post'] = $id_post;

    //     return $this->query("UPDATE {$this->table} SET {$sqlRequestPart} WHERE id_post = :id_post", $post_data);
    // }

    public function create(array $data, ?array $relations = null) {
        $this->isAdmin();
        parent::create($data);

        $id_post = $this->db->getPDO()->lastInsertId();

        foreach ($relations as $tag_id) {
            $stmt = $this->db->getPDO()->prepare("INSERT post_tag (id_post, id_tag) VALUES (?,?)");
            $stmt->execute(array($id_post, $tag_id));
        }

        return true;
    }

    public function update(int $id_post, array $post_data, ?array $relations = null) {
        $this->isAdmin();
        // Update post
        $sqlRequestPart = "";
        $i = 1;

        foreach ($post_data as $key => $value) {
            $commat = $i === count($post_data) ? "" : ', ';
            $sqlRequestPart .= "{$key} = :{$key}{$commat}";
            $i++;
        }

        $post_data['id_post'] = $id_post;

        $this->query("UPDATE {$this->table} SET {$sqlRequestPart} WHERE id_post = :id_post", $post_data);

        // Update tags

        // 1) remove existant tag for a post
        $stmt = $this->db->getPDO()->prepare("DELETE FROM post_tag WHERE id_post = ?");
        $result = $stmt->execute(array($id_post));

        if(!$result) {
            return false;
        }

        // 2) reinsert tags for a post
        foreach ($relations as $tag_id) {
            $stmt = $this->db->getPDO()->prepare("INSERT post_tag (id_post, id_tag) VALUES (?,?)");
            $stmt->execute(array($id_post, $tag_id));
        }
        
        if($result) {
            return true;
        }
    }
}