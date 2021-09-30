<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\Post;

class PostController extends Controller {

    private $table = "posts";

    public function index() {
        $post = new Post($this->getDB());
        $posts = $post->getAll();

        return $this->view('admin.post.index', compact('posts'));
    }

    public function destroy(int $id_post) {
        $post = new Post($this->getDB());
        $result = $post->destroy($id_post);

        if($result) {
            header('location: /admin/posts');
        }
    }

    public function edit(int $id_post) {
        $post = new Post($this->getDB());
        $post = $post->getById($id_post);

        return $this->view('admin.post.edit', compact('post'));
    }

    public function update(int $id_post){
        $post = new Post($this->getDB());
        $result = $post->update($id_post, $_POST);
        
        if($result) {
            header('location: /admin/posts');
        }
    }
}