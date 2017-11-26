<?php
require('model/Post.php');
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
echo $req;
