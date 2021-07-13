<?php
//CRUD
include (__DIR__."/commonFunction.php");
class CommentModel
{
    public function createComment($commentObj)
    {
        $sql="  INSERT INTO comments (user_id, subject_id, comment) 
                VALUES (
                        (SELECT id FROM users WHERE username = '".$_SESSION['username']."'),
                        '".$commentObj['subjectID']."',
                        '".$commentObj['comment']."')";
        commonFunction::connectDB()->exec($sql);
    }
    public function getComment($subjectID)
    {
        $sql="  SELECT comments.comment, users.username 
                FROM comments, users 
                WHERE   users.id = comments.user_id AND 
                        comments.subject_id = $subjectID";
        return commonFunction::connectDB()->query($sql);
    }
    public function updateComment()
    {

    }
    public function deleteComment()
    {
        
    }
}

?>