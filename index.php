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
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                if(isset($_GET['deleteComment']) && $_GET['deleteComment'] > 0){
                    deleteComment(htmlspecialchars($_GET['deleteComment']));
                    header('Location:'.$_SERVER['PHP_SELF'].'?action=post&id='.htmlspecialchars($_GET['id']));
                    die;
                }else{
                    post();
                }
            }else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        }elseif ($_GET['action'] == 'addComment') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                if (!empty($_POST['comment'])&&isset($_SESSION['author_id'])) {
                    addComment($_GET['id'], $_SESSION['author_id'] , $_POST['comment']);
                }else {
                    throw new Exception('Tous les champs ne sont pas remplis !');
                }
            }else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        }elseif ($_GET['action'] == 'updateComment') {
            if (isset($_GET['commentId']) && $_GET['commentId'] > 0) {
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
        }elseif ($_GET['action'] == 'deleteUser' && isset($_GET['userId']) && $_GET['userId']>0) {
            supprUser(htmlspecialchars($_GET['userId']));
        }
    }
    else {//Si GETaction n'est pas defini, on est sur l'accueil du blog
        listPosts();
    }
}
catch(Exception $e) { // S'il y a eu une erreur, alors...
    $errorMessage = $e->getMessage();
    require('view/errorView.php');
}
