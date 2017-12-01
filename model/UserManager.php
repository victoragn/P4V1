<?php
require_once("model/Manager.php");
require_once("model/User.php");

class UserManager extends Manager{
    public function getUsers(){
        $db = $this->dbConnect();
        $req = $db->query('SELECT author_id as id, pseudo, password, email, register_date as registerDate, role FROM users ORDER BY id');
        $users=array();
        while ($data = $req->fetch()){
            $user = new User($data);
            $users[]=$user;
        }

        return $users;
    }

    public function getUserById($userId){
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT author_id as id, pseudo, password, email, register_date as registerDate, role FROM users WHERE author_id = ?');
        $req->execute(array($userId));
        $data = $req->fetch();
        $user = new User($data);
        return $user;
    }
    
    public function checkUserAlreadyExist($pseudo,$email){
        $db = $this->dbConnect();
        $req1 = $db->prepare('SELECT COUNT(*) FROM users WHERE pseudo= :pseudo');
        $req2 = $db->prepare('SELECT COUNT(*) FROM users WHERE email= :email');
        $req1->execute(array('pseudo' => $pseudo));
        $req2->execute(array('email' => $email));
        $result = [
            intval($req1->fetch()[0]),
            intval($req2->fetch()[0])
        ];
        
        return $result;
    }
    
    public function addUser($pseudo,$password,$email){
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO users(pseudo, password, email, register_date, role) VALUES(?, ?, ?, NOW(),0)');
        $affectedLines = $req->execute(array($pseudo,$password,$email));

        return $affectedLines;
    }
    
    public function checkLogin($pseudo,$password){
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT author_id as id, password FROM users WHERE pseudo= :pseudo');
        $req->execute(array('pseudo' => $pseudo));
        $req = $req->fetch();
        $result=[
            "check" => password_verify($password,$req['password']),
            "id" => $req['id']
        ];

        return $result;
    }
}
