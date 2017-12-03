<?php
class User{
	private $_id;
    private $_pseudo;
    private $_password;
    private $_email;
    private $_registerDate;
    private $_role;

    public function __construct(){
        $nbArgs=func_num_args();
        $args=func_get_args()[0];

        if($nbArgs==0){

        }else if($nbArgs==1){
            $this->hydrate($args);
        }else{
            throw new Exception('Trop de paramètres dans le constructeur de User');
        }
    }

    public function hydrate(array $donnees){
      foreach ($donnees as $key => $value){
        $method = 'set'.ucfirst($key);

        if (method_exists($this, $method)){$this->$method($value);}
      }
    }

    public function getId(){ return $this->_id; }
    public function getPseudo(){ return $this->_pseudo;}
    public function getPassword(){ return $this->_password;}
    public function getEmail(){ return $this->_email;}
    public function getRegisterDate(){ return $this->_registerDate;}
    public function getRole(){ return $this->_role;}

    public function setId($id){$this->_id=(int) $id;}
    public function setPseudo($pseudo){
        if(is_string($pseudo) && strlen($pseudo)<255){
            $this->_pseudo=htmlspecialchars($pseudo);
        }
    }
    public function setPassword($password){
        if(is_string($password) && strlen($password)<256){
            $this->_password=$password;
        }
    }
    public function setEmail($email){
        if(is_string($email) && strlen($email)<256){
            $this->_email=htmlspecialchars($email);
        }
    }
    public function setRegisterDate($registerDate){
            $this->_registerDate=$registerDate;
    }
    public function setRole($role){$this->_role=(int) $role;}
}
