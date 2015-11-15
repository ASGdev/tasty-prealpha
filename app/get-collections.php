<?php
include_once('../conf.php');

$output = [];

    try {
        $db = new PDO('sqlite:'.$db_url);
        
        $result = $db->query('SELECT * FROM collections');
        //var_dump($result);
        foreach($result as $row)
        {
           
            $temp = [$row['title'], $row['image']];
            //var_dump($temp);
            array_push($output, $temp);
        }
        $db = null;
        
    }
    catch(PDOException $e)
    {
        print 'Exception : '.$e->getMessage();
    }
    echo json_encode($output);
?>