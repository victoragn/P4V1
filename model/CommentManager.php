<?php
require_once("model/Manager.php");
require_once("model/Comment.php");

class CommentManager extends Manager{
    public function getComments($postId){
        $db = $this->dbConnect();
        $req = $db->prepare(
            'SELECT comment_id as id, post_id as postId, author_id as authorId, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%i\') AS commentDate
            FROM comments
            WHERE post_id = ?
            ORDER BY comment_date
            DESC'
        );
        $req->execute(array($postId));
        if($req==false){
            throw new Exception('La requete de getComments a echouée !');
        }else{
            $comments=array();
            while ($data = $req->fetch()){
                $comment=new Comment($data);
                $comments[]=$comment;
            }
            return $comments;
        }
    }

    public function getCommentsByUserId($userId){
        $db = $this->dbConnect();
        $req = $db->prepare(
            'SELECT comment_id as id, post_id as postId, author_id as authorId, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%i\') AS commentDate
            FROM comments
            WHERE author_id = ?
            ORDER BY comment_date
            DESC'
        );
        $req->execute(array($userId));
        if($req==false){
            throw new Exception('La requete de getCommentByUserId a echouée !');
        }else{
            $comments=array();
            while ($data = $req->fetch()){
                $comment=new Comment($data);
                $comments[]=$comment;
            }
            return $comments;
        }
    }
    
    public function getComment($commentId){
        $db = $this->dbConnect();
        $req = $db->prepare(
            'SELECT comment_id as id, post_id as postId, author_id as authorId, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%i\') AS commentDate
            FROM comments
            WHERE comment_id = ?'
        );
        $req->execute(array($commentId));
        if ($req==false){
            throw new Exception('Ce commentaire n\'existe pas ou plus');
        }else{
            $result = $req->fetch();
            $comment=new Comment($result);
            return $comment;
        }
    }

    public function postComment($postId, $authorId, $comment){
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO comments(post_id, author_id, comment, comment_date) VALUES(?, ?, ?, NOW())');
        $req->execute(array($postId, $authorId, $comment));
        if($req==false){
            throw new Exception('La requete de postComment a echouée !');
        }else{
            return $req;
        }
    }
    
    public function updateComment($commentId, $commentContent){
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE comments SET comment= :comment, comment_date=NOW() WHERE comment_id= :comment_id');
        $req->execute(array(
            'comment' => $commentContent,
            'comment_id' => $commentId
        ));
        if($req==false){
            throw new Exception('La requete de updateComment a echouée !');
        }else{
            return $req;
        }
    }
      
    public function getPostIdByCommentId($commentId){
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT post_id as postId FROM comments WHERE comment_id = ?');
        $req->execute(array($commentId));
        if($req==false){
            throw new Exception('La requete de getPostIdByCommentId a echouée !');
        }else{
            $postId= $req->fetch()['postId'];
            return $postId;
        }
    }

    public function removeComment($commentId){
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM comments WHERE comment_id= :comment_id');
        $req->execute(array('comment_id' => $commentId));
        if($req==false){
            throw new Exception('La requete de removeComment a echouée !');
        }else{
            return $req;
        }
    }

    public function getNbSignalByCommentId($commentId){
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT COUNT(*) FROM signals WHERE comment_id= :commentId');
        $req->execute(array('commentId' => $commentId));
        if($req==false){
            throw new Exception('La requete de getNbSignal a echouée !');
        }else{
            $result=intval($req->fetch()[0]);
            return $result;
        }
    }

    public function getCommentsByNbSign($nbSign){
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT comment_id FROM signals GROUP BY comment_id HAVING COUNT(comment_id)>= :nbSignal');
        $req->execute(array('nbSignal' => $nbSign));
        if($req==false){
            throw new Exception('La requete de getCommentsByNbSign a echouée !');
        }else{
            $result=array();
            while ($data = $req->fetch()){
                $comment=$this->getComment($data[0]);
                $result[]=$comment;
            }
            return $result;
        }
    }

    public function checkSignal($commentId,$userId){
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT COUNT(*) FROM signals WHERE comment_id= :commentId AND author_id= :userId');
        $req->execute(array('commentId' => $commentId,'userId'=> $userId));
        if($req==false){
            throw new Exception('La requete de checkSignal a echouée !');
        }else{
            $result=intval($req->fetch()[0]);
            return $result;
        }
    }

    public function addSignal($commentId,$userId){
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO signals(comment_id, author_id) VALUES(?, ?)');
        $req->execute(array($commentId,$userId));
        if($req==false){
            throw new Exception('La requete de addSignal a echouée !');
        }else{
            return $req;
        }
    }

    public function deleteSignal($commentId,$userId){
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM signals WHERE comment_id= :commentId AND author_id= :userId');
        $req->execute(array('commentId' => $commentId,'userId'=> $userId));
        if($req==false){
            throw new Exception('La requete de deleteSignal a echouée !');
        }else{
            return $req;
        }
    }

    public function deleteAllSignalsFromComment($commentId){
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM signals WHERE comment_id= :commentId');
        $req->execute(array('commentId' => $commentId));
        if($req==false){
            throw new Exception('La requete de deleteAllSignalsFromComment a echouée !');
        }else{
            return $req;
        }
    }
}
