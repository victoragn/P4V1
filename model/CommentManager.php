<?php
require_once("model/Manager.php"); // Vous n'alliez pas oublier cette ligne ? ;o)

class CommentManager extends Manager{
    public function getComments($postId){
        $db = $this->dbConnect();
        $comments = $db->prepare(
            'SELECT c.id comment_id,u.pseudo author, c.comment comment, DATE_FORMAT(c.comment_date comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr
            FROM comments c
            INNER JOIN users u
            ON c.author_id = u.id
            WHERE c.post_id = ? 
            ORDER BY c.comment_date 
            DESC'
        );
        $comments->execute(array($postId));

        return $comments;
    }

    public function postComment($postId, $author_id, $comment){
        $db = $this->dbConnect();
        $comments = $db->prepare('INSERT INTO comments(post_id, author_id, comment, comment_date) VALUES(?, ?, ?, NOW())');
        $affectedLines = $comments->execute(array($postId, $author_id, $comment));

        return $affectedLines;
    }
    
    public function getComment($commentId){
        $db = $this->dbConnect();
        $req = $db->prepare(
            'SELECT c.id comment_id,c.post_id post_id, u.pseudo author, c.comment, DATE_FORMAT(c.comment_date comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr
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