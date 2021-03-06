<?php $title = 'Enregistrez-vous'; ?>

<?php ob_start(); ?>
<h1>Inscription</h1>
<p><a href="index.php">Retour à l'accueil</a></p><br/>

<div class="registerForm">
    <div id="messagesInfos">
        <p class="messRegister"><?php if (isset($userAlreadyExistMessage)){echo $userAlreadyExistMessage;} ?></p>
        <p class="messRegister"><?php if (isset($mailAlreadyExistMessage)){echo $mailAlreadyExistMessage;} ?></p>
        <p class="messRegister"><?php if (isset($differentPasswordMessage)){echo $differentPasswordMessage;} ?></p>
        <p class="messRegister"><?php if (isset($checkCaptchaMessage)){echo $checkCaptchaMessage;} ?></p>
        <?php $messChampVide='<span class="messChampVide" id="messPseudoVide">Vous devez remplir ce champ</span>'; ?>
    </div>
   <form action="register.php" method="post">
        <div>
            <label class="regLabel" for="pseudoReg">Pseudo :</label>
            <input class="<?= $pseudoColor ?>" id="pseudo_input" type="text" name="pseudoReg" value="<?php if(isset($_POST['pseudoReg'])){echo htmlspecialchars($_POST['pseudoReg']);}?>" />
            <?php if (isset($pseudoVide)){echo $messChampVide ;}?>
            <br />
            
            <label class="regLabel" for="password1">Mot de passe :</label>
            <input class="<?= $pwd1Color ?>" id="password_input1" type="password" name="password1"/>
            <?php if (isset($pwd1Vide)){echo $messChampVide ;}?>
            <br />
            
            <label class="regLabel" for="password2">Retapez le :</label>
            <input class="<?= $pwd2Color ?>" id="password_input2" type="password" name="password2"/>
            <?php if (isset($pwd2Vide)){echo $messChampVide ;}?>
            <br />
            
            <label class="regLabel" for="email">Email :</label>
            <input class="<?= $emailColor ?>" id="email_input" type="email" name="email" value="<?php if(isset($_POST['email'])){echo htmlspecialchars($_POST['email']);}?>" />
            <?php if (isset($emailVide)){echo $messChampVide ;}?>
            
            <div class="g-recaptcha" data-sitekey="6LfSVzoUAAAAADOuqcN9fTrBWdm5S-rKPfdM95uB"></div>
        </div>
        <div>
            <input class="frontBtn" type="submit" />
        </div>
    </form>
</div>
<script src='https://www.google.com/recaptcha/api.js'></script>
 
<?php
$content = ob_get_clean(); ?>

<?php require('templateRegister.php'); ?>
