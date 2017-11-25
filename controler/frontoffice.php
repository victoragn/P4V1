<?php

// Chargement des classes
require_once('model/PostManager.php');
require_once('model/CommentManager.php');
require_once('model/UserManager.php');

function listPosts(){
    $postManager = new PostManager(); // Création d'un objet
    $posts = $postManager->getPosts(); // Appel d'une fonction de cet objet
    
    require('view/frontoffice/listPostsView.php');
}

function post(){
    $postManager = new PostManager();
    $commentManager = new CommentManager();

    $post = $postManager->getPost($_GET['id']);
    $comments = $commentManager->getComments($_GET['id']);

    require('view/frontoffice/postView.php');
}

function addComment($postId, $author, $comment){
    $commentManager = new CommentManager();

    $affectedLines = $commentManager->postComment($postId, $author, $comment);

    if ($affectedLines === false) {
        throw new Exception('Impossible d\'ajouter le commentaire !');
    }else {
        header('Location: index.php?action=post&id=' . $postId);
    }
}

function updateComment($commentId, $author, $comment){
    $commentManager = new CommentManager();
    
    $postId=$commentManager->getPostIdByCommentId($commentId);
    $affectedLines = $commentManager->updateComment($commentId, $author, $comment);

    if ($affectedLines === false) {
        throw new Exception('Impossible de modifier le commentaire !');
    }else {
        header('Location: index.php?action=post&id='. $postId);
    }
}

function editComment($commentId){
    $postManager = new PostManager();
    $commentManager = new CommentManager();

    $comment = $commentManager->getComment($commentId);
    $post = $postManager->getPost($comment['post_id']);

    require('view/frontoffice/editCommentView.php');
}

function login($pseudo,$password){
    $userManager= new UserManager();
    $result=$userManager->checkLogin($pseudo,$password);
    
    if (!$result['check']){
        throw new Exception('Mauvais identifiant ou mot de passe');
    }else{
        $_SESSION['id'] = $result['id'];
        $_SESSION['pseudo'] = $pseudo;
        $_SESSION['test']='test';
    }
}
