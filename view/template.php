<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?= $title ?></title>
        <link href="/P4V1/public/css/styles.css" rel="stylesheet" /> 
    </head>
        
    <body>
        <?php 
            if (isset($_SESSION['author_id'])){
                require('view/frontoffice/userHeader.php');
            }else{
                require('view/frontoffice/logHeader.php');
            }
        ?>
        <?= $content ?>
    </body>
</html>
