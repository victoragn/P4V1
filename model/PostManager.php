<?php
require_once("model/Manager.php");
require_once("model/Post.php");

class PostManager extends Manager{
    public function getPosts(){
        $db = $this->dbConnect();
        $req = $db->query('SELECT id, title, content, creationDate FROM posts ORDER BY creationDate DESC LIMIT 0, 5');
        $result=array();
        while ($data = $req->fetch()){
            $post=new Post($data);
            $result[]=$post;
        }
        return $result;
    }

    public function getPost($postId){
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, title, content, creationDate FROM posts WHERE id = ?');
        $req->execute(array($postId));
        $result = $req->fetch();
        $post=new Post($result);
        return $post;
    }

    public function postPost($post){
        $arrayPost=[
            'title' => $post->title(),
            'content' => $post->content(),
            'creationDate' => $post->creationDate()
        ];

        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO posts(title, content, creationDate) VALUES (:title, :content, :creationDate)');
        $affectedLines=$req->execute($arrayPost);

        return $affectedLines;
    }
}
