<?php
require_once('model/CommentManager.php');

class Post{
	private $_id;
    private $_title;
    private $_content;
    private $_creationDate;

    private $_excerpt;
    private $_excerpt2;
    private $_nbComment;

    public function __construct(){
        $nbArgs=func_num_args();
        $args=func_get_args()[0];

        if($nbArgs==0){
        }else if($nbArgs==1){
            $this->hydrate($args);
        }else{
            throw new Exception('Trop de paramètres dans le constructeur de Post');
        }
    }

    public function hydrate(array $donnees){
      foreach ($donnees as $key => $value){
        $method = 'set'.ucfirst($key);

        if (method_exists($this, $method)){$this->$method($value);}
      }
        $this->setNbComment();
    }

    public function getId(){ return $this->_id; }
    public function getTitle(){ return $this->_title;}
    public function getContent(){ return $this->_content;}
    public function getCreationDate(){ return $this->_creationDate;}

    public function getExcerpt(){ return $this->_excerpt;}
    public function getExcerpt2(){ return $this->_excerpt2;}
    public function getNbComment(){ return $this->_nbComment;}

    public function setId($id){$this->_id=(int) $id;}
    public function setTitle($title){
        if(is_string($title) && strlen($title)<255){
            $this->_title=htmlspecialchars($title);
        }else{
            throw new Exception('Le titre doit contenir moins de 255 caractères');
        }
    }
    public function setExcerpt($content){
        $this->_excerpt=substr(strip_tags($content),0,50);
    }
    public function setExcerpt2($content){
        $resume=substr($content,0,700);
        $pos=strrpos($resume, " ");
        if($pos===false){
            $this->_excerpt2=substr($content,0,700);
        }else{
            $this->_excerpt2=substr($content,0,$pos);
        }
    }
    public function setContent($content){
        if(is_string($content)){
            $this->_content=$content;
            $this->setExcerpt($this->getContent());
            $this->setExcerpt2($this->getContent());
        }
    }
    public function setcreationDate($creationDate){
            $this->_creationDate=$creationDate;
    }

    public function setNbComment(){
        $commentManager=new CommentManager();
        $comments=$commentManager->getComments($this->getId());
        $this->_nbComment=count($comments);
    }
}
