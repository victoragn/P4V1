<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?= $title ?></title>
        <link href="/P4V1/public/css/styles.css" rel="stylesheet" />
        <script src='https://www.google.com/recaptcha/api.js'></script>
    </head>

    <body>
        <header>
            <h1>
                <span id="titrePrincipal1"><?= $title ?></span><br/>
                <span id="titrePrincipal2"><?php if(isset($title2)){echo $title2;} ?></span>
            </h1>
        <?php
            if (isset($_SESSION['author_id'])){
                require('view/frontoffice/userHeader.php');
            }else{
                require('view/frontoffice/logHeader.php');
            }
        ?>
        </header>
        <div id="content"><?= $content ?></div>
        <footer>
            <p>© 2017 Victor AGNEZ</p>
        </footer>
    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="../P4V1/public/js/script.js"></script>
</html>
