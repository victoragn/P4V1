<?php

// Chargement des classes
require_once('model/PostManager.php');
require_once('model/CommentManager.php');

function listPosts(){
    $postManager = new PostManager(); // Création d'un objet
    $posts = $postManager->getPosts(); // Appel d'une fonction de cet objet
    return $posts;
}

function post(){
    $postManager = new PostManager();
    $commentManager = new CommentManager();
    $userManager = new UserManager();

    $post = $postManager->getPost(htmlspecialchars($_GET['id']));
    $comments = $commentManager->getComments(htmlspecialchars($_GET['id']));

    require('view/frontoffice/postView.php');
}

function newPost($title,$content){
    $postManager=new PostManager();
    $postManager->postPost($title,$content);
    header('Location: index.php?action=dashboard');
}

function modifPost($postId,$postTitle,$postContent){
    $postManager=new PostManager();
    $postManager->editPost($postId,$postTitle,$postContent);
    header('Location: index.php?action=dashboard');
}

function getEditPost(){
    $postManager=new PostManager();
    $post=$postManager->getPost(intval($_GET['postId']));
    require('view/backoffice/dashEditPost.php');
}

function addComment($postId, $authorId, $commentContent){
    $commentManager = new CommentManager();
    if($authorId==$_SESSION['author_id']){
        $affectedLines = $commentManager->postComment($postId, $authorId, $commentContent);

        if ($affectedLines === false) {
            throw new Exception('Impossible d\'ajouter le commentaire !');
        }else {
            header('Location: index.php?action=post&id=' . $postId);
        }
    }
}

function modifComment($commentId, $commentContent){
    $commentManager = new CommentManager();
    $comment=$commentManager->getComment($commentId);
    if($comment->getAuthorId()==$_SESSION['author_id']||$_SESSION['role']==1){
        $postId=$comment->getPostId();
        $affectedLines = $commentManager->updateComment($commentId, $commentContent);

        if ($affectedLines === false) {
            throw new Exception('Impossible de modifier le commentaire !');
        }else {
            header('Location: index.php?action=post&id='. $postId);
        }
    }else{
        throw new Exception('Vous n\'etes pas identifié pour modifier le commentaire');
    }
}

function login($pseudo,$password){
    $userManager= new UserManager();
    $result=$userManager->checkLogin($pseudo,$password);
    
    if (!$result['check']){
        throw new Exception('Mauvais identifiant ou mot de passe');
    }else{
        $_SESSION['author_id'] = $result['id'];
        header('Location: index.php');
    }
}

function setCurrentUser($userId){
    $userManager= new UserManager();
    $user= $userManager->getUserById($userId);
    $_SESSION['role']=$user->getRole();
    $_SESSION['pseudo']=$user->getPseudo();
}

function getUserByComment($comment){
    $userManager=new UserManager();
    $authorId = $comment->getAuthorId();
    $user=$userManager->getUserById($authorId);
    return $user;
}

function supprComment($commentId){
    $commentManager=new CommentManager();
    $comment=$commentManager->getComment($commentId);
    if (!isset($_SESSION['author_id'])){
        throw new Exception('Vous devez vous authentifier !');
    }else{
        if ($comment->getAuthorId()!=$_SESSION['author_id']&&$_SESSION['role']!=1){
            throw new Exception('Vous n\'avez pas le droit de supprimer ce commentaire');
        }else{
            $result=$commentManager->deleteComment($comment);
            if($result===false){
                throw new Exception('La suppression du commentaire à échoué !');
            }
        }
    }
}

function deleteUser($userId){
    $userManager=new UserManager();
    $commentManager=new CommentManager();
    $comments=$commentManager->getCommentsByUserId($userId);
    foreach ($comments as &$comment){
        $commentManager->removeComment($comment->getId());
    }
    $result=$userManager->removeUser($userId);
}

function deletePost($postId){
    $postManager=new PostManager();
    $commentManager=new CommentManager();
    $comments=$commentManager->getComments($postId);
    foreach ($comments as &$comment){
        $commentManager->removeComment($comment->getId());
    }
    $result=$postManager->removePost($postId);
}

