<?php
require_once("model/Manager.php"); // Vous n'alliez pas oublier cette ligne ? ;o)

class PostManager extends Manager{
    public function getPosts(){
        $db = $this->dbConnect();
        $req = $db->query('SELECT id, title, content, DATE_FORMAT(creationDate, \'%d/%m/%Y à %Hh%imin%ss\') AS creationDateFr FROM posts ORDER BY creationDate DESC LIMIT 0, 5');

        return $req;
    }

    public function getPost($postId){
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, title, content, DATE_FORMAT(creationDate, \'%d/%m/%Y à %Hh%imin%ss\') AS creationDateFr FROM posts WHERE id = ?');
        $req->execute(array($postId));
        $post = $req->fetch();

        return $post;
    }
}
