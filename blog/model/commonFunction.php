<?php
if (session_status() == PHP_SESSION_NONE)    
    session_start();
class commonFunction
{
    public static $mainPath='http://localhost/blog/';
    public static function includeHeader()
    {
        $profileURL     = commonFunction::$mainPath."controller/UserController.php";
        $profileText    = "Signup";
        if (isset($_SESSION['username']))
        {
            $profileURL     .= "?userAction=profile";
            $profileText    = $_SESSION['username']." | <a href='".commonFunction::$mainPath."controller/UserController.php?userAction=logout'>logout</a>" ;
        }    
        $headerPagecontents = file_get_contents(__DIR__."/../view/html/header.html");
        echo str_replace(
            array("{{mainPath}}",
                "{{profileURL}}",
                "{{profileText}}"),
            array(commonFunction::$mainPath,
                 $profileURL, 
                 $profileText), 
            $headerPagecontents);
    }
    public static function connectDB()
    {
        $db = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    }
}     
?>