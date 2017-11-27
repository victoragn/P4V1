<?php
require_once("model/Manager.php");
require_once("model/Comment.php");

class CommentManager extends Manager{
    public function getComments($postId){
        $db = $this->dbConnect();
        $req = $db->prepare(
            'SELECT id , author_id as authorId, comment, comment_date as commentDate
            FROM comments
            WHERE post_id = ?
            ORDER BY comment_date
            DESC'
        );
        $req->execute(array($postId));
        $comments=array();
        while ($data = $req->fetch()){
            $comment=new Comment($data);
            $comments[]=$comment;
        }

        return $comments;
    }

    public function postComment($postId, $authorId, $comment){
        $db = $this->dbConnect();
        $comments = $db->prepare('INSERT INTO comments(post_id, author_id, comment, comment_date) VALUES(?, ?, ?, NOW())');
        $affectedLines = $comments->execute(array($postId, $authorId, $comment));

        return $affectedLines;
    }
    
    public function getComment($commentId){
        $db = $this->dbConnect();
        $req = $db->prepare(
            'SELECT id, post_id as postId, author_id as authorId, comment, comment_date as commentDate
            FROM comments
            WHERE id = ?'
        );
        $req->execute(array($commentId));
        $result = $req->fetch();
        $comment=new Comment($result);
        
        return $comment;
    }
    
    public function updateComment($commentId, $author_id, $comment){
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE comments SET author_id= :authorId, comment= :comment, comment_date=NOW() WHERE id= :id');
        $affectedLines =$req->execute(array(
            'authorId' => $author_id,
            'comment' => $comment,
            'id' => $commentId
        ));
        
        return $affectedLines;
    }
      
    public function getPostIdByCommentId($commentId){
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT post_id as postId FROM comments WHERE id = ?');
        $req->execute(array($commentId));
        $postId= $req->fetch()['postId'];
        return $postId;
    }
}
