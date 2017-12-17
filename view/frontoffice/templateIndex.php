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
        <?php
            if (isset($_SESSION['author_id'])){
                require('view/frontoffice/userHeader.php');
            }else{
                require('view/frontoffice/logHeader.php');
            }
        ?>
            <h1><?= $title ?></h1>
        </header>
        <?= $content ?>
        <footer>
        </footer>
    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="../P4V1/public/js/script.js"></script>
</html>
