<?php
include_once('../conf.php');

$output = [];

    try {
        $db = new PDO("sqlite:".$db_url);
        
        $result = $db->query('SELECT * FROM links');
        foreach($result as $row)
        {
           
            $temp = [$row['title'], $row['url'], $row['description'], $row['tags'], $row['categories'], $row['datetime'], $row['click_count'], $row['id'], $row['media_type'], $row['collections']];
            array_push($output, $temp);
        }
        
    }
    catch(PDOException $e)
    {
        print 'Exception : '.$e->getMessage();
    }
    echo json_encode($output);
?>