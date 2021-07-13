<?php
include(__DIR__.'/../model/subjectModel.php');
include(__DIR__.'/../model/ValidationModel.php');
include_once(__DIR__.'/../model/commonFunction.php');
$subjectController=new SubjectController();
$subjectController->handler();
class SubjectController
{
    public $mainPath='http://localhost/blog/';
    public function handler(){
        $subAction  = isset($_GET['subjectAction']) ? $_GET['subjectAction']: "";
        $pageNumber = isset($_GET['pageNum']) ? $_GET['pageNum']: 1;
        switch($subAction)
        {
            case 'add':
                $this->addSubject();
                break; 
            case 'edit':
                $this->editSubject();
                break;
            case 'getSubject':
                $this->getOneSubject($_GET['id']);
                break;
            default:
                $this->getSubjects($pageNumber);
                break;      
        }   
          
    }
    public function validation($id)
    {
        if(is_numeric($id) && $id > 0)
            return true;
        header(__DIR__."/../view/html/404.html");    
    }
    public function getSubjects($pageNumber)
    {
        $subjectModel   = new SubjectModel();
        $subjects       = $subjectModel->getSubjects($pageNumber);
        $subs = $subjects->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($subs);
    }
    public function addSubject(){
        if(! isset($_SESSION['username']))
        {
            setcookie("onAddNewSubject", "add", time() + (86400 * 30), "/");
            header("location: UserController.php");
        }    
        commonFunction::includeHeader();
        $subjectPagecontents = file_get_contents(__DIR__."/../view/html/manageSubject.html");
        echo str_replace(
            array(
                "{{mainPath}}",
                "{{header}}",
                "{{ID}}",
                "{{Title}}",
                "{{Description}}"),
            array($this->mainPath,
                "Heyy, you can add your new subject here!! ",
                "",
                "",
                ""
            ),
            $subjectPagecontents
        );
        $validation     = new ValidationModel();
        $current_link   = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        if(isset($_GET['errorMsg']))
        {
            echo"<p>please fill information first</p>";
        }
        if(isset($_POST['submit']))
        {
            $isValid=$validation->handler([$_POST['subjectTitle'],$_POST['subjectDescription']],["_isFilled","_isFilled"],$current_link);
            if($isValid)
            {
                $subjectObject  = array("Title"=>$_POST['subjectTitle'],"Description"=>$_POST['subjectDescription']);
                $subjectModel   = new SubjectModel();
                $subjectModel->addNewSubject($subjectObject);
                header('location:../index.php');
            }
        }
    }
    public function editSubject()
    {        
        commonFunction::includeHeader();
        $validation             = new ValidationModel();
        $subjectModel           = new SubjectModel();
        $toEditSubject          = $subjectModel->getSubjects(-1,$_GET['id']);
        $subjectPagecontents    = file_get_contents(__DIR__."/../view/html/manageSubject.html");
        echo str_replace(
            array("{{header}}","{{ID}}","{{Title}}","{{Description}}"),
            array("Hi human, Edit  ".$toEditSubject['Title']." Here :)",$toEditSubject['ID'], $toEditSubject['Title'], $toEditSubject['Description']),
            $subjectPagecontents
        );
        if(isset($_POST['submit']))
        {
            $subjectObject = array("ID"=>$_POST['id'], "Title"=>$_POST['subjectTitle'],"Description"=>$_POST['subjectDescription']);
            $subjectModel->editSubject($subjectObject);
            header('location:../index.php');
        }
    }
    public function getOneSubject($id)
    {
        $validation     = new ValidationModel();
        $current_link   = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $tags           = array("{{Title}}","{{Description}}","{{errorMsg}}","{{subjectId}}");
        $tagsValues     = array();
        if(isset($_GET['errorMsg'])){
            $tagsValues = array("", "","subject not found");
        }
        else
        {
            $validation->handler([$id],["_isNumeric"],$current_link);
            $subjectModel   = new SubjectModel();
            $subject        = $subjectModel->getSubjects(-1, $_GET['id']);
            $tagsValues     = array($subject['Title'], $subject['Description']," ",$_GET['id']);
        }    
        commonFunction::includeHeader();
        $subjectPagecontents = file_get_contents(__DIR__."/../view/html/subject.html");
        echo str_replace($tags,$tagsValues,$subjectPagecontents);
    }
}
?>