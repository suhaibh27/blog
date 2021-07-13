<?php
session_start();
include(__DIR__."/../model/commonFunction.php");
include(__DIR__.'/../model/UserModel.php');

$userCotroll=new UserController();

class UserController
{
    public function __construct()
    {
        $userAction  = isset($_GET['userAction']) ? $_GET['userAction']: "";
        switch($userAction)
        {
            case 'logout':
                $this->logout();
                break;
            case 'signup':
                $this->signUp();
                break;      
            case 'signin':
                $this->signin();
                break;
            case 'logout':
                $this->logout();
                break;
            case 'profile':
                $this->profile();
                break;      
            default:            
                $this->displaySignupForm();
                break;    
        }    
    }
    function displaySignupForm($errorMsg=FALSE)
    {
        commonFunction::includeHeader();
        $Pagecontents       = file_get_contents(__DIR__."/../view/html/signUp.html");
        $staticArray        = array("{{mainPath}}","{{errorMsg}}");
        $variablesArray     = array(commonFunction::$mainPath);
        array_push($variablesArray, $errorMsg ? "<div class='alert alert-danger' role='alert'>Please check your information</div>" : " ");
        echo str_replace($staticArray, $variablesArray,$Pagecontents);
    }
    function signUp ()
    {
        $userModel  = new UserModel();
        $newUser    = array("fullname"=>$_POST['fullname'],
                        "username"=>$_POST['username'],
                        "password"=>$_POST['password']);
        $userModel->createUser($newUser);
        header("location:../index.php");   
    }
    function signin()
    {
        $user           = array("username"=>$_POST['username'],
                                "password"=>$_POST['password']);
        $userModel      = new UserModel();
        $loggedinUser   = $userModel->getUser($user);
        if ($loggedinUser == null)
            $this->displaySignupForm(TRUE);
        else
        { 
            $_SESSION['username'] = $user['username'];
            if(isset($_COOKIE['onAddNewSubject']))
            {
                setcookie("onAddNewSubject", "", time() - 3600,"/");
                header("location:SubjectController.php?subjectAction=add");
            }
            else    
                header("location:../index.php");
        }       
    }
    function logout()
    {
        unset($_SESSION['username']);
        header("location:../index.php");   
    }
    function profile()
    {
        $staticArray    = array("{{Username}}","{{return message}}","{{alertStatus}}");
        $dynamicArray   = array($_SESSION['username'],"","");
        if(isset($_POST['editProfile']))
        {
            $user       = array( "username" => $_POST['username']);
            $userModel  = new UserModel();
            if(!$userModel->updateUser($user))
            {
                $dynamicArray[1] = "username already exist!! try again";
                $dynamicArray[2] = "danger";
            }
            else
            {
                $dynamicArray[0]        = $user['username'];
                $dynamicArray[1]        = "profile updated successfully.";
                $dynamicArray[2]        = "success";
                $_SESSION['username']   = $user['username'];
            }
        }
        commonFunction::includeHeader();
        $Pagecontents = file_get_contents(__DIR__."/../view/html/profile.html");
        echo str_replace($staticArray,$dynamicArray,$Pagecontents);
    }
}
?>