<?php

// Chargement des classes
require_once('model/PostManager.php');

function listPosts(){
    $postManager = new PostManager(); // Création d'un objet
    $posts = $postManager->getPosts(); // Appel d'une fonction de cet objet
    return $posts;
}

function getSignComments(){
    $commentManager=new CommentManager();
    $signComments=$commentManager->getCommentsByNbSign(2);
    return $signComments;
}

function post($postId){
    $postManager = new PostManager();
    $commentManager = new CommentManager();

    $post = $postManager->getPost(htmlspecialchars($postId));
    $comments = $commentManager->getComments(htmlspecialchars($postId));

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
            header('Location: index.php?action=post&id=' . $postId . '#comments');
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
            header('Location: index.php?action=post&id='. $postId . '#comments');
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
    $_SESSION['email']=$user->getEmail();
}

function getUserByComment($comment){
    $userManager=new UserManager();
    $authorId = $comment->getAuthorId();
    $user=$userManager->getUserById($authorId);
    return $user;
}

function allUsers(){
    $userManager=new UserManager();
    $users=$userManager->getUsers();
    return $users;
}

function modifProfil(){
    $champPassVide=0;
    $changePassDiff=0;
    $modifEmail=0;
    if(isset($_POST['oldPass'])){
        $userManager= new UserManager();
        if(isset($_POST['changeEmail'])&&$_POST['changeEmail']!=$_SESSION['email']){
            $checkEmail=$userManager->checkEmailAlreadyExist($_POST['changeEmail']);
            if($checkEmail==0){
                $userManager->updateUserEmail($_POST['changeEmail'],$_SESSION['author_id']);
                $modifEmail=1;
                setCurrentUser($_SESSION['author_id']);
            }
        }
        if(isset($_POST['oldPass'])&&isset($_POST['changePass1'])&&isset($_POST['changePass2'])&&(!empty($_POST['oldPass'])||!empty($_POST['changePass1'])||!empty($_POST['changePass2']))){
            if($_POST['changePass1']!=$_POST['changePass2']){
                $champPassDiff=1;
            }else{
                if(empty($_POST['oldPass'])||empty($_POST['changePass1'])||empty($_POST['changePass2'])){
                    $champPassVide=1;
                }else{
                    $checkOldPass=$userManager->checkLogin($_SESSION['pseudo'],$_POST['oldPass'])['check'];
                    if($checkOldPass==true){
                        $hashPassword=password_hash($_POST['changePass1'], PASSWORD_DEFAULT);
                        $userManager->updateUserPassword($hashPassword,$_SESSION['author_id']);
                        $modifPassword=1;
                    }
                }
            }
        }
    }
    require('view/frontoffice/profil.php');
}

function modifUser($userId){
    $champPassVide=0;
    $changePassDiff=0;
    $modifEmail=0;
    $modifPseudo=0;
    $userManager= new UserManager();
    $user=$userManager->getUserById($userId);

    $userPseudo=$user->getPseudo();
    $userEmail=$user->getEmail();

    if(isset($_POST['changePass1'])){//si le formulaire a été rempli
         if(isset($_POST['changePseudo'])&&$_POST['changePseudo']!=$user->getPseudo()){//changer pseudo
            $checkPseudo=$userManager->checkPseudoAlreadyExist($_POST['changePseudo']);
            if($checkPseudo==0){
                $userManager->updateUserPseudo($_POST['changePseudo'],$user->getId());
                $userPseudo=$_POST['changePseudo'];
                $modifPseudo=1;
            }
        }
        if(isset($_POST['changeEmail'])&&$_POST['changeEmail']!=$user->getEmail()){//changer email
            $checkEmail=$userManager->checkEmailAlreadyExist($_POST['changeEmail']);
            if($checkEmail==0){
                $userManager->updateUserEmail($_POST['changeEmail'],$user->getId());
                $userEmail=$_POST['changeEmail'];
                $modifEmail=1;
            }
        }
        if(isset($_POST['changePass1'])&&isset($_POST['changePass2'])&&(!empty($_POST['changePass1'])||!empty($_POST['changePass2']))){//changement du mdp
            if($_POST['changePass1']!=$_POST['changePass2']){
                $changePassDiff=1;
            }else{
                if(empty($_POST['changePass1'])||empty($_POST['changePass2'])){
                    $champPassVide=1;
                }else{
                    $hashPassword=password_hash($_POST['changePass1'], PASSWORD_DEFAULT);
                    $userManager->updateUserPassword($hashPassword,$user->getId());
                    $modifPassword=1;
                }
            }
        }
    }
    require('view/backoffice/dashUserEdit.php');
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
            $commentManager->deleteAllSignalsFromComment($comment->getId());
            $commentManager->removeComment($comment->getId());
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

function toggleSignal($onOff,$commentId){
    $commentId=(int)htmlspecialchars($commentId);
    $commentManager=new CommentManager();
    $checkSignal=$commentManager->checkSignal($commentId,$_SESSION['author_id']);
    if(htmlspecialchars($onOff)=="on"){
        if ($checkSignal==1){
            throw new Exception('Le commentaire est déjà signalé !');
        }else{
            $commentManager->addSignal($commentId,$_SESSION['author_id']);
        }
    }elseif(htmlspecialchars($onOff)=="off"){
        if ($checkSignal==0){
            throw new Exception('Le signalement n\'existe pas et ne peux donc pas être retiré!');
        }else{
            $commentManager->deleteSignal($commentId,$_SESSION['author_id']);
        }
    }else{
        throw new Exception('La valeur de signal est fausse !');
    }
}

