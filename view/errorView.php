<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Erreur</title>
        <link href="/P4V1/public/css/styles.css" rel="stylesheet" />
        <script src='https://www.google.com/recaptcha/api.js'></script>
    </head>


<h1>Une erreur s'est produite !</h1>
<div class="blocErreur">
    <?php 
        echo $errorMessage;
    ?>
</div>

<a href="index.php">Retour à la page d'acceuil</a>

