<?php
require_once("model/Manager.php");
require_once("model/Post.php");

class PostManager extends Manager{
    public function getPosts(){
        $db = $this->dbConnect();
        $req = $db->query('SELECT post_id as id, post_title as title, post_content as content, post_creation_date as creationDate FROM posts ORDER BY post_creation_date DESC LIMIT 0, 5');
        $result=array();
        while ($data = $req->fetch()){
            $post=new Post($data);
            $result[]=$post;
        }
        return $result;
    }

    public function getPost($postId){
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT post_id as id, post_title as title, post_content as content, post_creation_date as creationDate FROM posts WHERE post_id = ?');
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
        $req = $db->prepare('INSERT INTO posts(post_title, post_content, post_creation_date) VALUES (:title, :content, :creationDate)');
        $affectedLines=$req->execute($arrayPost);

        return $affectedLines;
    }
}
