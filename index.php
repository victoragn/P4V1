<?php
if(!isset($_SESSION)) {session_start();} 
require('controler/frontoffice.php');

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
                post();
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
        }elseif ($_GET['action'] == 'disconnect') {
            $_SESSION = array();
            session_destroy();
            header('Location: index.php');
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
