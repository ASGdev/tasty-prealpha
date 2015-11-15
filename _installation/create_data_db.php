<?php

try {
     $file_db = new PDO('sqlite:tasty.db');
        // Set errormode to exceptions
        $file_db->setAttribute(PDO::ATTR_ERRMODE, 
                                PDO::ERRMODE_EXCEPTION);
    try {
    $file_db->exec("CREATE TABLE IF NOT EXISTS links (
                        id INTEGER PRIMARY KEY, 
                        title TEXT, 
                        link TEXT, 
                        description TEXT)");
    }
    catch(PDOException $e) {
    // Print PDOException message
    echo $e->getMessage();
  }
    
}
catch(PDOException $e) {
    // Print PDOException message
    echo $e->getMessage();
  }
?>