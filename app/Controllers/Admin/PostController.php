<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\Post;
use App\Models\Tag;

class PostController extends Controller {

    private $table = "posts";

    public function index() {
        $post = new Post($this->getDB());
        $posts = $post->getAll();

        return $this->view('admin.post.index', compact('posts'));
    }

    public function create() {
        $tags = new Tag($this->getDB());
        $tags = $tags->getAll();
        return $this->view('admin.post.form', compact('tags'));
    }

    public function createPost() {
        $post = new Post($this->getDB());

        $tags = array_pop($_POST); //

        $result = $post->create($_POST, $tags);
        
        if($result) {
            header('location: /admin/posts');
        }
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

        $tag = new Tag($this->getDB());
        $tags = $tag->getAll();

        return $this->view('admin.post.form', compact('post', 'tags'));
    }

    public function update(int $id_post){
        $post = new Post($this->getDB());

        $tags = array_pop($_POST);

        $result = $post->update($id_post, $_POST, $tags);
        
        if($result) {
            header('location: /admin/posts');
        }
    }
}