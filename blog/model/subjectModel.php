<?php
include (__DIR__."/commonFunction.php");
class SubjectModel
{
	public function getSubjects($pageNumber = 1, $id=-1)
	{
		$sql="	SELECT subjects.ID, subjects.Title, subjects.Description, subjects.date, users.username 
				FROM subjects 
				INNER JOIN users ON subjects.user_id=users.id";
		if($id > -1)
		{
			$sql.=" WHERE subjects.ID = $id";
			$stmt = commonFunction::connectDB()->prepare($sql); 
			$stmt->execute(); 
			$row = $stmt->fetch();
			return $row;
		}
		if($pageNumber <= 0)
			$pageNumber = 1;
		$numOfPages = ($pageNumber-1)*4;
		$sql.=" ORDER BY date DESC 
				LIMIT 4 OFFSET $numOfPages";
			return commonFunction::connectDB()->query($sql);
	}
	public function addNewSubject($subject)
	{
		$sql="INSERT INTO subjects (Title,
		 							Description, user_id) 
				VALUES(	'".$subject['Title']."',
				 		'".$subject['Description']."'
				 		,(SELECT id FROM users WHERE username = '".$_SESSION['username']."'))";
		commonFunction::connectDB()->exec($sql);
	}
	public function editSubject($subject){
		$sql= "UPDATE subjects SET Title='".$subject['Title']."', Description='".$subject['Description']."' WHERE ID='".$subject['ID']."'"; 
		commonFunction::connectDB()->exec($sql);
	}
}		
?>