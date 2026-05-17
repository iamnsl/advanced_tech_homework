<?php
require_once 'core/Database.php';

class User
{

    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }

    //Find user by email or username
    public function findUserByUsername($username)
    {
        $this->db->query('SELECT * FROM User WHERE user= :username ');
        $this->db->bind(':username', $username);

        $user = $this->db->single();

        //Check user that fetched from the querry
        if ($this->db->rowCount() > 0) {
            return $user;
        } else {
            return false;
        }
    }

    //Register User
    public function register($data)
    {
        $this->db->query('INSERT INTO User (user, password) 
        VALUES (:name, :password)');
        //Bind values
        $this->db->bind(':name', $data['usersName']);
        $this->db->bind(':password', $data['usersPwd']);

        //Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    //Login user
    public function login($username, $password)
    {
        $user = $this->findUserByUsername($username);

        if ($user == false)
            return false;

        $hashedPassword = $user->password;
        if (password_verify($password, $hashedPassword)) {
            return $user;
        } else {
            return false;
        }
    }
}