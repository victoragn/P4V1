<?php

class Manager
{
    protected function dbConnect(){
        $db = new PDO('mysql:host=db717023765.db.1and1.com;dbname=db717023765;charset=utf8', 'dbo717023765', 'O2p2e2n4!');
        return $db;
    }
}
