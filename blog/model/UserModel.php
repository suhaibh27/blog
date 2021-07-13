<?php
class UserModel
{
    function createUser($user)
    {
        $user['password']=password_hash($user['password'],PASSWORD_DEFAULT);
        $sql="INSERT INTO 
                users (username,
                        password,
                        full_name) 
                VALUES( '".$user['username']."',
                        '".$user['password']."',
                        '".$user['fullname']."')";
        commonFunction::connectDB()->exec($sql);                
    }
    function getUser($user,$checkPassword=true, $selectStmt="username, password", $whereCond="username = '{{username}}'")
    {
        $whereCond   = str_replace("{{username}}",$user['username'],$whereCond);
        // $whereCond   = str_replace("",,$whereCond);

        $sql= "SELECT $selectStmt
                FROM users 
                WHERE $whereCond";   
        $stmt = commonFunction::connectDB()->prepare($sql); 
        $stmt->execute(); 
        $row = $stmt->fetch();
        if (empty($row) || ($checkPassword && !password_verify($user['password'],$row['password'])))
            return null;
        return $row;
    }
    function updateUser($user)
    {
        if($this->getUser($user,false)!=null)   
            return false;
        $sql="  UPDATE users 
                SET username    ='".$user['username']."' 
                WHERE username  ='".$_SESSION['username']."'" ;
        commonFunction::connectDB()->exec($sql);
        return true;
    }
    function deleteUser()
    {

    }
}
?>