<?php
require_once("model/Manager.php");

class UserManager extends Manager{
    public function getUsers(){
        $db = $this->dbConnect();
        $req = $db->query('SELECT id, pseudo, email, DATE_FORMAT(register_date, \'%d/%m/%Y\') AS register_date_fr FROM users ORDER BY id');

        return $req;
    }

    public function getUser($userId){
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id,pseudo, email, DATE_FORMAT(register_date, \'%d/%m/%Y\') AS register_date_fr FROM users WHERE id = ?');
        $req->execute(array($userId));
        $user = $req->fetch();

        return $user;
    }
    
    public function getUserName($userId){
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT pseudo FROM users WHERE id = ?');
        $req->execute(array($userId));
        $user = $req->fetch();

        return $user;
    }
    
    public function checkUserAlreadyExist($pseudo,$email){
        $db = $this->dbConnect();
        $req1 = $db->prepare('SELECT COUNT(*) FROM users WHERE pseudo= :pseudo');
        $req2 = $db->prepare('SELECT COUNT(*) FROM users WHERE email= :email');
        $req1->execute(array('pseudo' => $pseudo));
        $req2->execute(array('email' => $email));
        $result = [intval($req1->fetch()[0]),intval($req2->fetch()[0])];
        
        return $result;
    }
    
    public function addUser($pseudo,$password,$email){
        $db = $this->dbConnect();
        $users = $db->prepare('INSERT INTO users(pseudo, password, email, register_date, role) VALUES(?, ?, ?, NOW(),0)');
        $affectedLines = $users->execute(array($pseudo,$password,$email));

        return $affectedLines;
    }
    
    public function checkLogin($pseudo,$password){
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, password FROM users WHERE pseudo= :pseudo');
        $req->execute(array('pseudo' => $pseudo));
        $req = $req->fetch();
        $result=[
            "check" => password_verify($password,$req['password']),
            "id" => $req['id']
        ];

        return $result;
    }
}