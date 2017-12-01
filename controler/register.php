<?php

// Chargement des classes
require_once('model/UserManager.php');
require_once('controler/frontoffice.php');
require_once('controler/recaptchalib.php');
$siteKey = '6LfSVzoUAAAAADOuqcN9fTrBWdm5S-rKPfdM95uB'; // votre clé publique
$secret = '6LfSVzoUAAAAAASIbgZ9YYg_eBoJf-nupcyxuJMk'; // votre clé privée

$reCaptcha = new ReCaptcha($secret);
if(isset($_POST["g-recaptcha-response"])) {
    $resp = $reCaptcha->verifyResponse(
        $_SERVER["REMOTE_ADDR"],
        $_POST["g-recaptcha-response"]
        );
    if ($resp != null && $resp->success) {
        $checkCaptcha=1;
    }else {
        $checkCaptcha=0;
    }
}

$userAlreadyExist;
$mailAlreadyExist;
$differentPassword;

function getForm(){
    global $userAlreadyExist,$mailAlreadyExist,$differentPassword,$checkCaptcha;
    $pseudoColor="fondBlanc";
    $pwd1Color="fondBlanc";
    $pwd2Color="fondBlanc";
    $emailColor="fondBlanc";
    
    if (isset($_POST['pseudoReg'])||isset($_POST['password1'])||isset($_POST['password2'])||isset($_POST['email'])){
        if(htmlspecialchars($_POST['pseudoReg'])==""){$pseudoVide=1;$pseudoColor="fondRouge";}
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
    if (isset($differentPassword) && $differentPassword==1){
        $differentPasswordMessage='Les deux mots de passe sont différents !';
        $pwd1Color="fondRouge";
        $pwd2Color="fondRouge";
    }

    if (isset($checkCaptcha) && $checkCaptcha==0){
        $checkCaptchaMessage='Le captcha est incorrect !';
    }

    require('view/register/registerView.php');
}

function checkUserAlreadyExist($pseudo,$password1,$password2,$email){
    global $userAlreadyExist,$mailAlreadyExist,$differentPassword,$checkCaptcha; //global vars to go to getForm()
    $pseudo=strtolower($pseudo);//pseudo in lowercase for checking in DB
    $email=strtolower($email);
    $userManager = new UserManager(); 
    $check_result = $userManager->checkUserAlreadyExist($pseudo,$email);
    
    if(($check_result[0]!=0 && $check_result[0]!=1)||($check_result[1]!=0 && $check_result[1]!=1)){
        throw new Exception('Attention, la vérification de l\'existence du pseudo et du mail a échouée !');
    }else{
        if ($password1===$password2){
            $differentPassword=0;
        }else{
            $differentPassword=1;
        }
        $userAlreadyExist=$check_result[0];
        $mailAlreadyExist=$check_result[1];

        if ($check_result==[0,0] && $differentPassword==0 && $checkCaptcha==1){
            $hash_password= password_hash($password, PASSWORD_DEFAULT);
            $affectedLines = $userManager->addUser($pseudo,$hash_password,$email);
            if ($affectedLines === false) {
                throw new Exception('Impossible d\'ajouter le nouvel utilisateur !');
            }else {
                header('Location: index.php?action=disconnect');
            }
        }
    }
    
    getForm();
}
