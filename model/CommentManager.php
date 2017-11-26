<?php
require_once("model/Manager.php");
require_once("model/Comment.php");

class CommentManager extends Manager{
    public function getComments($postId){
        $db = $this->dbConnect();
        $req = $db->prepare(
            'SELECT id , author_id as authorId, comment, comment_date as commentDate
            FROM comments c
            WHERE c.post_id = ? 
            ORDER BY c.comment_date 
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
            'SELECT c.id comment_id,c.post_id post_id, u.pseudo author, c.comment, c.comment_date
            FROM comments c
            INNER JOIN users u
            ON c.author_id = u.id
            WHERE id = ?'
        );
        $req->execute(array($commentId));
        $comment = $req->fetch();
        
        return $comment;
    }
    
    public function updateComment($commentId, $author_id, $comment){
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE comments SET author_id= :author_id, comment= :comment, comment_date=NOW() WHERE id= :commentId');
        $affectedLines =$req->execute(array(
            'author_id' => $author_id,
            'comment' => $comment,
            'commentId' => $commentId
        ));
        
        return $affectedLines;
    }
      
    public function getPostIdByCommentId($commentId){
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT post_id FROM comments WHERE id = ?');
        $req->execute(array($commentId));
        $postId= $req->fetch()['post_id'];
        return $postId;
    }
}
