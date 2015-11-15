<?php
$request_body = file_get_contents('php://input');
parse_str($request_body, $get_array);
//var_dump($get_array);
	
    try {
        $db = new PDO('sqlite:../db/data.sqlite');
        $stmt = $db->prepare("UPDATE links SET click_count=:count WHERE id=:id");
        $stmt->bindParam(':id', $get_array['id']);
        $stmt->bindParam(':count', $get_array['count']);
        
        $stmt->execute();
        echo '1';
    }
    catch(PDOException $e)
    {
        echo 'Exception : '.$e->getMessage();
    }


?>