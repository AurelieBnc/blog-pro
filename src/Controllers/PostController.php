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
    public function index()
    {
        // we instantiate the model corresponding to the "posts" table
        $post = new Post;

        // we will look for all the posts
        // todo : optionally add the ability to disable a post by adding an "active" property and findBy(['active' => 1])
        $posts = $post->findAll();
        $this->twig->display('post/index.twig', ['ROOT' => $this->root,'posts' => $posts,'session' => $_SESSION]);
    }

    /**
     * show a particular post
     */
    public function retailPost(int $id)
    {
        $post = new Post;
        $post = $post->find($id);

        $user = new User;
        $users = $user->findAll();

        $commentData = ['id_post' => $id];

        $comment = new Comment;
        $comments = $comment->findBy($commentData);

        $this->twig->display('post/retailPost.twig', ['ROOT' => $this->root, 'post' => $post, 'session' => $_SESSION, 'comments' => $comments, 'users' => $users]);
    }

    public function createPost()
    {
        if ($_SESSION['logUser'] === 'admin') {
            $model = new Post;
            $post = $model
                ->setTitle($_POST['title'])
                ->setLead($_POST['lead'])
                ->setContent($_POST['content'])
                ->setId_User($_SESSION['id']);

            $model->create($post);
            $lastId = $post->lastId();

            $this->retailPost($lastId);
        }
    }

    public function editPostPage(int $postId)
    {
        $model = new Post;
        $post = $model->find($postId);

        return $this->twig->display('post/editPost.twig', ['ROOT' => $this->root, 'post' => $post, 'session' => $_SESSION]);
    }

    public function editPost()
    {
        $postId = $_POST['postId'];
        $title = $_POST['title'];
        $lead = $_POST['lead'];
        $content = $_POST['content'];
        $model = new Post;
        $editPost = new Post;

        if(isset($title) && !empty($title)){
            $editPost = $model->setTitle($title);
        }
        if(isset($lead) && !empty($lead)){
            $editPost = $model->setLead($lead);
        }
        if(isset($content) && !empty($content)){
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

    public function deletePost()
    {
        $postId = $_POST['postId'];
        $logUser = $_SESSION['logUser'];

        if(isset($postId) && $logUser === 'admin')
        {
            $data = ['id_post'=> $postId];
            $modelComment = new Comment;
            $listComments = $modelComment->findBy($data);
            foreach($listComments as $comment)
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