<?php
include 'Student.php';
include 'helpers/session_helper.php';
class Students
{

    private $studentModel;

    public function __construct()
    {
        $this->studentModel = new Student;
    }
    public function read()
    {
        $students = $this->studentModel->findAllStudents($_SESSION['id']);
        if (isset($students)) {
            return $students;
        }
    }
    public function addStudent()
    {

        //Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        //Init data
        $data = [
            'fname' => trim($_POST['prenom']),
            'lname' => trim($_POST['nom']),
            'email' => trim($_POST['email']),
            'age' => trim($_POST['age']),
            'userid' => $_SESSION['id']
        ];

        //Validate inputs
        if (empty($data['fname']) || empty($data['lname']) || empty($data['email']) || empty($data['age'])) {
            flash("add", "Please fill out all inputs");
            redirect("../public/addstudent.php");
        }

        // check if student already exists
        if ($this->studentModel->findStudentByEmail($data['email'])) {
            flash("add", "Student with this email already exists");
            redirect("../public/addstudent.php");
        }

        //Register User

        if ($this->studentModel->addStudent($data)) {
            redirect("../public/index.php");
        } else {
            die("Something went wrong");
        }
    }

    public function viewUpdateStudent($id)
    {
        $student = $this->studentModel->findStudentById($id);

        return $student;

    }
    public function update($id)
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        //Init data
        $data = [
            'prenom' => trim($_POST['prenom']),
            'nom' => trim($_POST['nom']),
            'age' => trim($_POST['age']),
            'email' => trim($_POST['email']),
            'updateid' => $_POST['updateid'],
            'userid' => $_SESSION['id']
        ];

        if ($this->studentModel->updateStudent($data)) {
            redirect("../public/index.php");
        } else {
            die("Something went wrong");
        }
        return $data;
    }

    public function deleteStudent($id)
    {

        if ($this->studentModel->deleteStudent($id)) {
            redirect("../public/index.php");
        } else {
            die("Something went wrong");
        }
    }
}

$test = new Students;
$students = $test->read();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    switch ($_POST['type']) {
        case 'add':
            $test->addStudent();
            break;
        case 'update':
            $test->update($_POST['updateid']);
            break;
        default:
            redirect("../public/index.php");
    }

} else {
    if (isset($_GET["deleteid"])) {
        $test->deleteStudent($_GET["deleteid"]);
    } elseif (isset($_GET["udpateid"])) {
        $updatestud = $test->viewUpdateStudent($_GET["udpateid"]);
    }
}