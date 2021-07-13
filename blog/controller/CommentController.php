<?php
include(__DIR__."/../model/CommentModel.php");
$commentController=new CommentController();
class CommentController
{
    public function __construct()
    {
        $commentAction  = isset($_GET['commentAction']) ? $_GET['commentAction']: "";
        switch($commentAction)
        {
            case ('getComments'):
                $this->getComment();
                break;
            default:
                $this->addComment();
                break;
        }
    }
    public function addComment(){
        $commentModel   = new CommentModel();
        $commentArray   = array(
                            "comment"=>$_POST["comment"],
                            "subjectID"=>$_POST["sid"]
                        );
        $commentModel->createComment($commentArray);
        echo $_SESSION['username'];
    }
    public function getComment()
    {
        $commentModel   = new CommentModel();
        $com            = $commentModel->getComment($_GET['id']);
        $comments       = $com->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($comments);
    }
}
?>