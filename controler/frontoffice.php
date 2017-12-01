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

function updateComment($commentId, $commentContent){
    $commentManager = new CommentManager();
    $comment=$commentManager->getComment($commentId);
    $postId=$comment->postId();
    $affectedLines = $commentManager->updateComment($commentId, $commentContent);

    if ($affectedLines === false) {
        throw new Exception('Impossible de modifier le commentaire !');
    }else {
        header('Location: index.php?action=post&id='. $postId);
    }
}

function login($pseudo,$password){
    $userManager= new UserManager();
    $result=$userManager->checkLogin($pseudo,$password);
    
    if (!$result['check']){
        throw new Exception('Mauvais identifiant ou mot de passe');
    }else{
        $_SESSION['author_id'] = $result['id'];
    }
}

function getUserById($userId){
    $userManager= new UserManager();
    $user= $userManager->getUserById($userId);

    return $user;
}

function getUserByComment($comment){
    $userManager=new UserManager();
    $authorId = $comment->authorId();
    $user=$userManager->getUserById($authorId);
    return $user;
}
