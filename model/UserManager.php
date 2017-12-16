<?php
require_once("model/Manager.php");
require_once("model/User.php");

class UserManager extends Manager{
    public function getUsers(){
        $db = $this->dbConnect();
        $req = $db->query('SELECT author_id as id, pseudo, password, email, register_date as registerDate, role FROM users ORDER BY id');
        if($req==false){
            throw new Exception('La requete de getUsers a echouée !');
        }else{
            $users=array();
            while ($data = $req->fetch()){
                $user = new User($data);
                $users[]=$user;
            }
            return $users;
        }
    }

    public function getUserById($userId){
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT author_id as id, pseudo, password, email, register_date as registerDate, role FROM users WHERE author_id = ?');
        $req->execute(array($userId));
        if($req==false){
            throw new Exception('La requete de getUserById a echouée !');
        }else{
            $data = $req->fetch();
            $user = new User($data);
            return $user;
        }
    }
    
    public function checkUserAlreadyExist($pseudo,$email){
        $db = $this->dbConnect();
        $req1 = $db->prepare('SELECT COUNT(*) FROM users WHERE pseudo= :pseudo');
        $req2 = $db->prepare('SELECT COUNT(*) FROM users WHERE email= :email');
        $req1->execute(array('pseudo' => $pseudo));
        $req2->execute(array('email' => $email));
        if($req1==false||$req2==false){
            throw new Exception('L\'une des requete de checkUserAlreadyExist a echouée !');
        }else{
            $result = [
                intval($req1->fetch()[0]),
                intval($req2->fetch()[0])
            ];
            return $result;
        }
    }
    
    public function checkEmailAlreadyExist($email){
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT COUNT(*) FROM users WHERE email= :email');
        $req->execute(array('email' => $email));
        if($req==false){
            throw new Exception('La requete de checkEmailAlreadyExist a echouée !');
        }else{
            $result = intval($req->fetch()[0]);
            return $result;
        }
    }

    public function addUser($pseudo,$password,$email){
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO users(pseudo, password, email, register_date, role) VALUES(?, ?, ?, NOW(),0)');
        $req->execute(array($pseudo,$password,$email));
        if($req==false){
            throw new Exception('La requete de addUser a echouée !');
        }else{
            return $req;
        }
    }
    
    public function checkLogin($pseudo,$password){
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT author_id as id, password FROM users WHERE pseudo= :pseudo');
        $req->execute(array('pseudo' => $pseudo));
        if($req==false){
            throw new Exception('La requete de checkLogin a echouée !');
        }else{
            $req = $req->fetch();
            $result=[
                "check" => password_verify($password,$req['password']),
                "id" => $req['id']
            ];
            return $result;
        }
    }

    public function updateUserEmail($email,$authorId){
        $db = $this->dbConnect();
        $arrayPost=[
            'email' => $email,
            'authorId' => $authorId
        ];
        $req = $db->prepare('UPDATE users SET email= :email WHERE author_id = :authorId');
        $req->execute($arrayPost);
        if($req==false){
            throw new Exception('La requete de updateUserEmail a echouée !');
        }else{
            return $req;
        }
    }

    public function updateUserPassword($password,$authorId){
        $db = $this->dbConnect();
        $arrayPost=[
            'password' => $password,
            'authorId' => $authorId
        ];
        $req = $db->prepare('UPDATE users SET password= :password WHERE author_id = :authorId');
        $req->execute($arrayPost);
        if($req==false){
            throw new Exception('La requete de updateUserPassword a echouée !');
        }else{
            return $req;
        }
    }

    public function removeUser($userId){
        $db = $this->dbConnect();
        $req = $db->query('DELETE FROM users WHERE author_id = ?');
        $req->execute(array($userId));
        if($req==false){
            throw new Exception('La requete de removeUser a echouée !');
        }else{
            return $req;
        }
    }
}
