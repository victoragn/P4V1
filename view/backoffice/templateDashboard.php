<!DOCTYPE html>
<html>
    <head>
        <meta name="robots" content="noindex, nofollow">
        <meta charset="utf-8" />
        <title><?= $title ?></title>
        <link href="/P4V1/public/css/styles.css" rel="stylesheet" />
        <script src='https://cloud.tinymce.com/stable/tinymce.min.js'></script>
        <script>
        tinymce.init({
            width:"100%",
            height:"600px",
            selector: '#mytextarea'
        });
        </script>
    </head>

    <body id="dashBody">
        <?= $content ?>
    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="../P4V1/public/js/script.js"></script>
</html>
