<?php
require_once 'User.php';
require_once 'helpers/session_helper.php';

class Users
{

    private $userModel;

    public function __construct()
    {
        $this->userModel = new User;
    }

    public function register()
    {

        //Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        //Init data
        $data = [
            'usersName' => trim($_POST['user']),
            'usersPwd' => trim($_POST['password']),
            'pwdRepeat' => trim($_POST['pwdRepeat'])
        ];

        //Validate inputs
        if (empty($data['usersName']) || empty($data['usersPwd']) || empty($data['pwdRepeat'])) {
            flash("register", "Please fill out all inputs");
            redirect("../public/signup.php");
        }
        //Validate password length and check password confiramtion
        if (strlen($data['usersPwd']) <= 3) {
            flash("register", "Invalid password");
            redirect("../public/signup.php");
        } else if ($data['usersPwd'] !== $data['pwdRepeat']) {
            flash("register", "Passwords don't match");
            redirect("../public/signup.php");
        }

        //User with the same username or password already exists
        if ($this->userModel->findUserByUsername($data['usersName'])) {
            flash("register", "Username already taken");
            redirect("../public/signup.php");
        }

        //Passed all validation checks.
        //Now going to hash password
        $data['usersPwd'] = password_hash($data['usersPwd'], PASSWORD_DEFAULT);

        //Register User
        if ($this->userModel->register($data)) {
            redirect("../public/login.php");
        } else {
            die("Something went wrong");
        }
    }

    public function login()
    {
        //Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        //Init data
        $data = [
            'user' => trim($_POST['user']),
            'password' => trim($_POST['password'])
        ];

        if (empty($data['user']) || empty($data['password'])) {
            flash("login", "Please fill out all inputs");
            header("location: ../public/login.php");
            exit();
        }

        //Check for username
        if ($this->userModel->findUserByUsername($data['user'])) {
            //User Found
            $loggedInUser = $this->userModel->login($data['user'], $data['password']);
            if ($loggedInUser) {
                //Create session
                $this->createUserSession($loggedInUser);
            } else {
                flash("login", "Password Incorrect");
                redirect("../public/login.php");
            }
        } else {
            flash("login", "No user found");
            redirect("../public/login.php");
        }
    }

    public function createUserSession($user)
    {
        $_SESSION['id'] = $user->id;
        $_SESSION['user'] = $user->user;
        redirect("../public/index.php");
    }

    public function logout()
    {
        unset($_SESSION['user']);
        session_destroy();
        redirect("../public/index.php");
    }
}

$init = new Users;
//Ensure that user is sending a post request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    switch ($_POST['type']) {
        case 'register':
            $init->register();
            break;
        case 'login':
            $init->login();
            break;
        default:
            redirect("../public/index.php");
    }

} else {
    switch ($_GET['q']) {
        case 'logout':
            $init->logout();
            break;
        default:
            redirect("../public/login.php");
    }
}