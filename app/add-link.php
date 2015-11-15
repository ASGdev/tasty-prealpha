<?php
include_once("conf.php");

$request_body = file_get_contents('php://input');
parse_str($request_body, $get_array);
//var_dump($get_array);
if(isset($get_array['collections'])){
    $_cats = json_encode($get_array['collections']);
}
else {
    $_cats = "";
}
if(isset($get_array['categories'])){
    $_colls = json_encode($get_array['categories']);
}
else {
    $_colls = "";
}


    if(!empty($get_array['title']) && !empty($get_array['url'])){
        try {
        $db = new PDO('sqlite:../data/data.sqlite');
        $stmt = $db->prepare("INSERT INTO links (title, url, description, tags, datetime, media_type, categories, collections) VALUES (:title, :url, :description, :tags, :datetime, :type, :categories, :collections)");
        $stmt->bindParam(':title', $get_array['title']);
        $stmt->bindParam(':url', $get_array['url']);
        $stmt->bindParam(':description', $get_array['description']);
        $stmt->bindParam(':tags', $get_array['tags']);
        $stmt->bindParam(':datetime', $get_array['datetime']);
        $stmt->bindParam(':type', $get_array['type']);
        $stmt->bindParam(':categories', $_cats);
        $stmt->bindParam(':collections', $_colls);
        $stmt->execute();
        echo '1';
        }
        catch(PDOException $e)
        {
            echo 'Exception : '.$e->getMessage();
        }
    }
    else {
        echo "Error empty field";
    }
	// now connect to Alexandrie API
    // it's buggy right there
    /*if($alexandrie_enabled){
        $urlencoded = urlencode($get_array['url']);
        $payload = file_get_contents($alexandrie_api.'index.php?action=add&source=tasty&key=.'$appkey'.&url='.$urlencoded);
    }*/
	
?>