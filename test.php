<?php
/*require('model/Post.php');
require('model/PostManager.php');
$postManager=new PostManager();
$post2=$postManager->getPost(7);
$args=[
    'title'=>'essaititre2',
    'content'=>'essai ffff ffff  fffff  ffffcontenu un peu long',
    'creationDate'=>'2017-11-09 08:48:26'
];

$post=new Post($args);
var_dump($post2);
$req=$postManager->postPost($post);
echo $req;*/
?>

<!DOCTYPE html>
<html>
<head>
  <script src='https://cloud.tinymce.com/stable/tinymce.min.js'></script>
  <script>
  tinymce.init({
    selector: '#mytextarea'
  });
  </script>
</head>

<body>
<h1>TinyMCE Quick Start Guide</h1>
  <form method="post">
    <textarea id="mytextarea">Hello, World!</textarea>
  </form>
</body>
</html>
