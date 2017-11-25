<?php

// Chargement des classes
require_once('model/UserManager.php');

$userAlreadyExist;
$mailAlreadyExist;

function getForm(){
    global $userAlreadyExist,$mailAlreadyExist;
    $pseudoColor="fondBlanc";
    $pwd1Color="fondBlanc";
    $pwd2Color="fondBlanc";
    $emailColor="fondBlanc";
    
    if (isset($_POST['pseudo'])||isset($_POST['password1'])||isset($_POST['password2'])||isset($_POST['email'])){
        if(htmlspecialchars($_POST['pseudo'])==""){$pseudoVide=1;$pseudoColor="fondRouge";}
        if(htmlspecialchars($_POST['password1'])==""){$pwd1Vide=1;$pwd1Color="fondRouge";}
        if(htmlspecialchars($_POST['password2'])==""){$pwd2Vide=1;$pwd2Color="fondRouge";}
        if(htmlspecialchars($_POST['email'])==""){$emailVide=1;$emailColor="fondRouge";}
    }

    if (isset($userAlreadyExist) && $userAlreadyExist==1){
        $userAlreadyExistMessage='Ce pseudo est déjà utilisé. Merci d\'en utiliser un autre';
        $pseudoColor="fondRouge";
    }
    if (isset($mailAlreadyExist) && $mailAlreadyExist==1){
        $mailAlreadyExistMessage='Ce mail est déjà utilisé. Merci d\'en utiliser un autre';
        $emailColor="fondRouge";
    }
    require('view/register/registerView.php');
}

function checkUserAlreadyExist($pseudo,$password,$email){
    global $userAlreadyExist,$mailAlreadyExist; //global vars to go to getForm()
    $pseudo=strtolower($pseudo);//pseudo in lowercase for checking in DB
    $email=strtolower($email);
    $userManager = new UserManager(); 
    $check_result = $userManager->checkUserAlreadyExist($pseudo,$email);
    
    if ($check_result==[0,0]){
        $userAlreadyExist=0;
        $mailAlreadyExist=0;
        $hash_password= password_hash($password, PASSWORD_DEFAULT);
        $affectedLines = $userManager->addUser($pseudo,$hash_password,$email);
        if ($affectedLines === false) {
            throw new Exception('Impossible d\'ajouter le nouvel utilisateur !');
        }else {
            header('Location: index.php');
        }
        
    }else if($check_result==[1,0]){
        $userAlreadyExist=1;
        $mailAlreadyExist=0;
    }else if($check_result==[0,1]){
        $userAlreadyExist=0;
        $mailAlreadyExist=1;
    }else if($check_result==[1,1]){
        $userAlreadyExist=1;
        $mailAlreadyExist=1;
    }else{
        throw new Exception('Attention, la vérification de l\'existence du pseudo et du mail a échouée !');
    }
    
    getForm();
}