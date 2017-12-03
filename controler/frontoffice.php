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

    $post = $postManager->getPost(htmlspecialchars($_GET['id']));
    $comments = $commentManager->getComments(htmlspecialchars($_GET['id']));

    require('view/frontoffice/postView.php');
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

function updateComment($commentId, $commentContent){
    $commentManager = new CommentManager();
    $comment=$commentManager->getComment($commentId);
    if($comment->authorId()==$_SESSION['author_id']||$_SESSION['role']==1){
        $postId=$comment->postId();
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

function getCurrentUser($userId){
    $userManager= new UserManager();
    $user= $userManager->getUserById($userId);
    $_SESSSION['role']=$user->role();
    $_SESSION['pseudo']=$user->pseudo();
}

function getUserByComment($comment){
    $userManager=new UserManager();
    $authorId = $comment->authorId();
    $user=$userManager->getUserById($authorId);
    return $user;
}

function getCommentsByUserId($userId){
    $commentManager=new CommentManager();
    $comments=$commentManager->getCommentsByUserId($userId);

    return $comments;
}


function deleteComment($commentId){
    $commentManager=new CommentManager();
    $comment=$commentManager->getComment($commentId);
    if (!isset($_SESSION['author_id'])){
        throw new Exception('Vous devez vous authentifier !');
    }else{
        if ($comment->authorId()!=$_SESSION['author_id']&&$_SESSION['role']!=1){
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
    if (!isset($_SESSION['author_id'])){
        throw new Exception('Vous devez vous authentifier !');
    }else{
        if ($_SESSION['author_id']!=$userId && $_SESSION['role']!=1){
            throw new Exception('Vous n\'avez pas le droit de supprimer ce compte d\'utilisateur');
        }else{
            $userManager=new UserManager();
            $comments=getCommentsByUserId($userId);
            foreach ($comments as &$comment){
                deleteComment($comment->id());
            }
            $result=$userManager->deleteUser($userId);
            if($result==false){
                throw new Exception('La suppression de l\'utilisateur à échoué !');
            }
        }
    }
}
