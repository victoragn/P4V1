<?php
require_once("model/Manager.php");
require_once("model/Comment.php");
/*require_once("model/UserManager.php");*/

class CommentManager extends Manager{
    public function getComments($postId){
        $db = $this->dbConnect();
        $req = $db->prepare(
            'SELECT comment_id as id, post_id as postId, author_id as authorId, comment, comment_date as commentDate
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

    public function getCommentsByUserId($userId){
        $db = $this->dbConnect();
        $req = $db->prepare(
            'SELECT comment_id as id, post_id as postId, author_id as authorId, comment, comment_date as commentDate
            FROM comments
            WHERE author_id = ?
            ORDER BY comment_date
            DESC'
        );
        $req->execute(array($userId));
        $comments=array();
        while ($data = $req->fetch()){
            $comment=new Comment($data);
            $comments[]=$comment;
        }

        return $comments;
    }
    
    public function getComment($commentId){
        $db = $this->dbConnect();
        $req = $db->prepare(
            'SELECT comment_id as id, post_id as postId, author_id as authorId, comment, comment_date as commentDate
            FROM comments
            WHERE comment_id = ?'
        );
        $req->execute(array($commentId));
        $result = $req->fetch();
        if ($result==false){
            throw new Exception('Ce commentaire n\'existe pas ou plus');
        }else{
            $comment=new Comment($result);
            return $comment;
        }
    }

    public function postComment($postId, $authorId, $comment){
        $db = $this->dbConnect();
        $comments = $db->prepare('INSERT INTO comments(post_id, author_id, comment, comment_date) VALUES(?, ?, ?, NOW())');
        $affectedLines = $comments->execute(array($postId, $authorId, $comment));

        return $affectedLines;
    }
    
    public function updateComment($commentId, $commentContent){
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE comments SET comment= :comment, comment_date=NOW() WHERE comment_id= :comment_id');
        $affectedLines =$req->execute(array(
            'comment' => $commentContent,
            'comment_id' => $commentId
        ));
        
        return $affectedLines;
    }
      
    public function getPostIdByCommentId($commentId){
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT post_id as postId FROM comments WHERE comment_id = ?');
        $req->execute(array($commentId));
        $postId= $req->fetch()['postId'];
        return $postId;
    }

    public function deleteComment($comment){
        $db = $this->dbConnect();
        $commentId=$comment->id();
        $req = $db->prepare('DELETE FROM comments WHERE comment_id= :comment_id');
        $affectedLines =$req->execute(array('comment_id' => $commentId));

        return $affectedLines;
    }
}
