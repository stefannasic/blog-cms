<?php

class Dashboard extends Controller {
    public function index(){
        $data = [];

        $post = new Post;
        $joins = [
            'users' => 'posts.user_id = users.id',
            'categories' => 'posts.category_id = categories.id'
        ];
        $selectColumns = [
            'users' => ['email'],
            'categories' => ['category_name']
        ];
        $data['posts'] = $post->joinTables($joins, $selectColumns, 'posts.id');
        

        $comment = new Comment;
        $joins = [
            'users' => 'comments.user_id = users.id'
        ];
        $selectColumns = [
            'users' => ['email']
        ];
        $data['comments'] = $comment->joinTables($joins, $selectColumns, 'comments.id');
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST['comment'] = esc($_POST['comment']);
            
            $_POST['user_id'] = $_SESSION['user']->id;

            if ($comment->validateComment($_POST)) {
                $comment->insert($_POST);
                redirect('dashboard');
            }

            $data['errors'] = $comment->errors;
        }
        
        if (!empty($_SESSION['user'])) {
            $this->view('dashboard', $data);
        } else {
            redirect('signin');
        }
    }

    public function deletePost() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['post_id'])) {
            $post = new Post;
            $post_id = $_POST['post_id'];

            $existingPost = $post->first(['id' => $post_id]);
            if ($existingPost && ($existingPost->user_id == $_SESSION['user']->id || $_SESSION['user']->role_id == 2)) {
                $post->delete($post_id);
                redirect('dashboard');
            }
        }
        redirect('dashboard');
    }

    public function deleteComment() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comment_id'])) {
            $comment = new Comment;
            $comment_id = $_POST['comment_id'];

            $existingComment = $comment->first(['id' => $comment_id]);
            if ($existingComment && ($existingComment->user_id == $_SESSION['user']->id || $_SESSION['user']->role_id == 2)) {
                $comment->delete($comment_id);
                redirect('dashboard');
            }
        }
        redirect('dashboard');
    }

    public function updatePost() {
        $post = new Post;
        $data['posts'] = $_POST;
        dd($data['posts']);
    }

    public function updateComment() {
        $comment = new Comment;
        $data['comments'] = $_POST;
        dd($data['comments']);
    }
}
