<?php
namespace App\Controllers;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;

Class PostController extends AbstractController
{


    public function __construct() {
        parent::__construct();
    }


    /**
     * Method displaying the list of all posts
     */
    public function index(): ?self
    {
        // we instantiate the model corresponding to the "posts" table
        $post = new Post;

        // we will look for all the posts
        $posts = $post->findAll();
        return $this->twig->display('post/index.twig', ['ROOT' => $this->root,'posts' => $posts,'session' => $_SESSION]);
    }


    /**
     * displays the detail of an item
     */
    public function retailPost(int $id): ?self
    {
        $post = new Post;
        $post = $post->find($id);

        $user = new User;
        $users = $user->findAll();

        $commentData = ['id_post' => $id];

        $comment = new Comment;
        $comments = $comment->findBy($commentData);

        return $this->twig->display('post/retailPost.twig', ['ROOT' => $this->root, 'post' => $post, 'session' => $_SESSION, 'comments' => $comments, 'users' => $users]);
    }


    /**
     * function to create a post
     */
    public function createPost(): ?self
    {
        $title = htmlspecialchars($_POST['title']);
        $lead = htmlspecialchars($_POST['lead']);
        $content = htmlspecialchars($_POST['content']);
        $userId = htmlspecialchars($_SESSION['id']);
        $sessionLogUser = $_SESSION['logUser'];

        if ( $sessionLogUser === 'admin') {
            $model = new Post;
            $post = $model
                ->setTitle($title)
                ->setLead($lead)
                ->setContent($content)
                ->setId_User($userId);

            $model->create($post);
            $lastId = $post->lastId();

            return $this->retailPost($lastId);
        }
    }


    /**
     * function to display edit post page
     */
    public function editPostPage(int $postId): void
    {
        $model = new Post;
        $post = $model->find($postId);

        $this->twig->display('post/editPost.twig', ['ROOT' => $this->root, 'post' => $post, 'session' => $_SESSION]);
    }


    /**
     * function that allows you to edit an article
     */
    public function editPost(): void
    {
        $postId = htmlspecialchars($_POST['postId']);
        $title = htmlspecialchars($_POST['title']);
        $lead = htmlspecialchars($_POST['lead']);
        $content = htmlspecialchars($_POST['content']);

        $model = new Post;
        $editPost = new Post;

        if(!empty($title)){
            $editPost = $model->setTitle($title);
        }
        if(!empty($lead)){
            $editPost = $model->setLead($lead);
        }
        if(!empty($content)){
            $editPost = $model->setContent($content);
        }

        if (!empty($editPost)) {
            $id = "id = ".$postId;
            $model->update($id, $editPost);
            echo "données bien mise à jour";
           $editPost = $model->find($postId);
        }

        $editPostId = $editPost['id'];

        $this->retailPost($editPostId);
    }


    /**
     * function to delete a post and and all his comments
     */
    public function deletePost(): void
    {
        $postId = htmlspecialchars($_POST['postId']);
        $logUser = htmlspecialchars($_SESSION['logUser']);

        if ($logUser === 'admin')
        {
            $data = ['id_post'=> $postId];
            $modelComment = new Comment;
            $listComments = $modelComment->findBy($data);
            foreach ($listComments as $comment)
            {
                $commentId = $comment['id'];
                $model = new Comment;
                $model->delete($commentId);
            }

            $model = new Post;
            $model->delete($postId);
            echo 'L\'article et ses commentaires ont bien été supprimés';
        }

        $this->index();
    }


}
