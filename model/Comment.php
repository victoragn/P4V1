<?php
require_once('model/UserManager.php');

class Comment{

    private $_id;
    private $_postId;
    private $_authorId;
    private $_comment;
    private $_commentDate;

    public function __construct(){
        $nbArgs=func_num_args();
        $args=func_get_args()[0];

        if($nbArgs==0){

        }else if($nbArgs==1){
            $this->hydrate($args);
        }else{
            throw new Exception('Trop de paramètres dans le constructeur de Comment');
        }
    }

    public function hydrate(array $donnees){
      foreach ($donnees as $key => $value){
        $method = 'set'.ucfirst($key);

        if (method_exists($this, $method)){$this->$method($value);}
      }
    }

    public function getId(){ return $this->_id; }
    public function getPostId(){ return $this->_postId;}
    public function getAuthorId(){ return $this->_authorId;}
    public function getComment(){ return $this->_comment;}
    public function getCommentDate(){ return $this->_commentDate;}

    public function setId($id){$this->_id=(int) $id;}
    public function setPostId($postId){$this->_postId=(int) $postId;}
    public function setAuthorId($authorId){$this->_authorId=(int) $authorId;}
    public function setComment($comment){
        if(is_string($comment)){
            $this->_comment=nl2br(htmlspecialchars($comment));
        }
    }
    public function setcommentDate($commentDate){
            $this->_commentDate=$commentDate;
    }

    public function getUser(){
        $userManager=new UserManager();
        $user=$userManager->getUserById($this->getAuthorId());
        return $user;
    }
}
