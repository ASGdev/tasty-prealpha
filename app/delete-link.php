<?php
include_once('../vendor/auth.php');
include_once("conf.php");

parse_str($file_get_contents('php://input'), $request);

if(isset($_SESSION['user_name']) && ($_SESSION['user_is_logged_in']==true)){
    if((!$allow_action) || (!$allow_link_deletion)){
        try {
            $db = new PDO('sqlite:../db/data.sqlite');
            $stmt = $db->prepare("DELETE FROM links WHERE title=:title AND date=:datetime");
            $stmt->bindParam(':title', $request['title']);
            $stmt->bindParam(':datetime', $request['datetime']);  
            $stmt->execute();
            echo '1';
        }
        catch(PDOException $e)
        {
            echo 'Exception : '.$e->getMessage();
        }
    }
    else {
        echo 'Erro - Operation forbidden';
    }
}
else {
	echo 'Action interdite.';
}

?>

