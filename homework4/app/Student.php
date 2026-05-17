<?php
require_once 'core/Database.php';

class Student
{
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }
    public function findAllStudents($userid)
    {
        $this->db->query('SELECT * FROM Student WHERE id_user= :userid ORDER BY prenom ASC');
        $this->db->bind(':userid', $userid);

        $students = $this->db->resultSet();
        $std = json_decode(json_encode($students), true);
        return $std;
    }
    public function findStudentByEmail($email)
    {
        $this->db->query('SELECT * FROM Student  WHERE email= :email ');
        $this->db->bind(':email', $email);

        $student = $this->db->single();
        $std = json_decode(json_encode($student), true);
        //Check user that fetched from the querry
        if ($this->db->rowCount() > 0) {
            return $std;
        } else {
            return false;
        }
    }
    public function findStudentById($id)
    {
        $this->db->query('SELECT * FROM Student  WHERE id= :id ');
        $this->db->bind(':id', $id);

        $student = $this->db->single();
        $std = json_decode(json_encode($student), true);
        //Check user that fetched from the querry
        if ($this->db->rowCount() > 0) {
            return $std;
        } else {
            return false;
        }
    }

    public function addStudent($data)
    {
        $this->db->query('INSERT INTO Student (nom, prenom,age,email,id_user) 
        VALUES (:nom, :prenom,:age,:email,:user)');
        //Bind values
        $this->db->bind(':nom', $data['lname']);
        $this->db->bind(':prenom', $data['fname']);
        $this->db->bind(':age', $data['age']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':user', $data['userid']);

        //Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateStudent($data)
    {
        $this->db->query('UPDATE Student SET nom = :nom, prenom = :prenom,age=:age, email= :email WHERE id= :id ');
        $this->db->bind(':nom', $data['nom']);
        $this->db->bind(':prenom', $data['prenom']);
        $this->db->bind(':age', $data['age']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':id', $data['updateid']);

        //Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteStudent($id)
    {
        $this->db->query('DELETE FROM Student WHERE id= :id ');
        $this->db->bind(':id', $id);

        //Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}