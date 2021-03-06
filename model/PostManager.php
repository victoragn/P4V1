<?php
require_once("model/Manager.php");
require_once("model/Post.php");

class PostManager extends Manager{
    public function getPosts(){
        $db = $this->dbConnect();
        $req = $db->query('SELECT post_id as id, post_title as title, post_content as content, DATE_FORMAT(post_creation_date, \'%d/%m/%Y à %Hh%i\') AS creationDate FROM posts ORDER BY post_creation_date DESC');
        if($req==false){
            throw new Exception('La requete de getPosts a echouée !');
        }else{
            $result=array();
            while ($data = $req->fetch()){
                $post=new Post($data);
                $result[]=$post;
            }
            return $result;
        }
    }

    public function getPost($postId){
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT post_id as id, post_title as title, post_content as content, DATE_FORMAT(post_creation_date, \'%d/%m/%Y à %Hh%i\') AS creationDate FROM posts WHERE post_id = ?');
        $req->execute(array($postId));
        if($req==false){
            throw new Exception('La requete de getPost a echouée !');
        }else{
            $result = $req->fetch();
            $post=new Post($result);
            return $post;
        }
    }

    public function postPost($title,$content){
        $arrayPost=[
            'title' => htmlspecialchars($title),
            'content' => $content
        ];

        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO posts(post_title, post_content, post_creation_date) VALUES (:title, :content, NOW())');
        $req->execute($arrayPost);
        if($req==false){
            throw new Exception('La requete de postPost a echouée !');
        }else{
            return $req;
        }
    }

    public function editPost($postId,$postTitle,$postContent){
        $arrayPost=[
            'title' => htmlspecialchars($postTitle),
            'content' => $postContent,
            'postId' => $postId
        ];

        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE posts SET post_title= :title, post_content= :content WHERE post_id= :postId');
        $req->execute($arrayPost);
        if($req==false){
            throw new Exception('La requete de editPost a echouée !');
        }else{
            return $req;
        }
    }

    public function removePost($postId){
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM posts WHERE post_id= ?');
        $req->execute(array($postId));
        if($req==false){
            throw new Exception('La requete deremovePost a echouée !');
        }else{
            return $req;
        }
    }
}
