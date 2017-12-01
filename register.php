<?php 
if(!isset($_SESSION)) {session_start();}
require('controler/register.php');
    
try {
    if (!empty($_POST['pseudoReg']) && !empty($_POST['password1']) && !empty($_POST['password2']) && !empty($_POST['email'])){
        checkUserAlreadyExist(htmlspecialchars($_POST['pseudoReg']),htmlspecialchars($_POST['password1']),htmlspecialchars($_POST['email']));
        
    }else{
        getForm(); 
    }
    
}
catch(Exception $e) { // S'il y a eu une erreur, alors...
    $errorMessage = $e->getMessage();
    require('view/errorView.php');
}
