<?php
if(!isset($_SESSION)) {session_start();} 
require('controler/frontoffice.php');

if(isset($_SESSION['author_id'])){//si la session est lancée est que l'id est définie
        setCurrentUSer($_SESSION['author_id']);
    }


try {
     if(isset($_POST['pseudo'])||isset($_POST['password'])){//si retour du formulaire de login
        if(htmlspecialchars($_POST['pseudo'])!="" && htmlspecialchars($_POST['password'])!=""){
            login(htmlspecialchars($_POST['pseudo']),htmlspecialchars($_POST['password']));
        }else{
            throw new Exception('Un des champs n\'est pas rempli');
        }
    }

    if (isset($_GET['action'])) {//Tous les cas où GETaction est défini
        if ($_GET['action'] == 'listPosts') {
            listPosts();
        }elseif ($_GET['action'] == 'post') {
            if (isset($_GET['id']) && $_GET['id'] > -1) {
                if(isset($_GET['deleteComment']) && $_GET['deleteComment'] > -1){
                    supprComment(htmlspecialchars($_GET['deleteComment']));
                    header('Location:'.$_SERVER['PHP_SELF'].'?action=post&id='.htmlspecialchars($_GET['id']));
                    die;
                }else{
                    post();
                }
            }else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        }elseif ($_GET['action'] == 'addComment') {
            if (isset($_GET['id']) && $_GET['id'] > -1) {
                if (!empty($_POST['comment'])&&isset($_SESSION['author_id'])) {
                    addComment($_GET['id'], $_SESSION['author_id'] , $_POST['comment']);
                }else {
                    throw new Exception('Tous les champs ne sont pas remplis !');
                }
            }else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        }elseif ($_GET['action'] == 'updateComment') {
            if (isset($_GET['commentId']) && $_GET['commentId'] > -1) {
                if (isset($_POST['modifComment'])) {
                    modifComment($_GET['commentId'], $_POST['modifComment']);
                }else {
                    throw new Exception('Pas de commentaire modifié envoyé');
                }
            }else {
                throw new Exception('Le numéro de commentaire à mettre à jour est invalide');
            }

        }elseif ($_GET['action'] == 'disconnect') {
            $_SESSION = array();
            session_destroy();
            header('Location: index.php');

        }elseif ($_GET['action'] == 'deleteUser' && isset($_GET['userId']) && $_GET['userId']>-1) {
            if(!isset($_SESSION['role'])||$_SESSION['role']!=1){
                throw new Exception('Vous n\'avez pas le droit de supprimer un utilisateur');
            }else{
                deleteUser(htmlspecialchars($_GET['userId']));
            }

        }elseif ($_GET['action'] == 'deletePost' && isset($_GET['postId']) && $_GET['postId']>-1) {
            if(!isset($_SESSION['role'])||$_SESSION['role']!=1){
                throw new Exception('Vous n\'avez pas le droit de supprimer cet article');
            }else{
                deletePost(htmlspecialchars($_GET['postId']));
                header('Location: index.php?action=dashboard');
            }

        }elseif ($_GET['action'] == 'dashboard') {
            if(!isset($_SESSION['role'])||$_SESSION['role']!=1){
                throw new Exception('Vous n\'avez pas le droit d\'ouvrir le dashboard');
            }else{
                if (isset($_GET['page']) && $_GET['page']=='users') {
                    require('view/backoffice/dashUsers.php');
                }elseif (isset($_GET['page']) && $_GET['page']=='newPost') {
                    require('view/backoffice/dashNewPost.php');
                }else{
                    $posts=listPosts();
                    require('view/backoffice/dashPosts.php');
                }
            }
        }
    }
    else {//Si GETaction n'est pas defini, on est sur l'accueil du blog
        $posts=listPosts();
        require('view/frontoffice/listPostsView.php');
    }
}
catch(Exception $e) { // S'il y a eu une erreur, alors...
    $errorMessage = $e->getMessage();
    require('view/errorView.php');
}
