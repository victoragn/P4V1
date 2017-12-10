<?php
class Post{
	private $_id;
    private $_title;
    private $_content;
    private $_creationDate;

    private $_excerpt;

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
    }

    public function getId(){ return $this->_id; }
    public function getTitle(){ return $this->_title;}
    public function getContent(){ return $this->_content;}
    public function getCreationDate(){ return $this->_creationDate;}

    public function getExcerpt(){ return $this->_excerpt;}

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
    public function setContent($content){
        if(is_string($content)){
            $this->_content=$content;
            $this->setExcerpt($this->getContent());
        }
    }
    public function setcreationDate($creationDate){
            $this->_creationDate=$creationDate;
    }
}
