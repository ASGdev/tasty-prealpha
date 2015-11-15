<?php

$db_url = "sqlite:../db/data.sqlite";
/*$db_url = "sqlite:../api/data-test.sqlite";*/

    try {
        $db = new PDO($db_url);
        
        $result = $db->query('SELECT * FROM links');
        foreach($result as $row)
        {
			$tags = explode(",", $row['tags']);
			$tags_output = "";
			foreach($tags as $tag){
				$tags_output = $tags_output.'<a href="#" onclick="open_tag('.$tag.')" class="btn btn-default btn-sm">'.$tag.'</a>&nbsp;';
			}
            echo '<div class="panel panel-default">
                    <div class="panel-heading">'
                    .$row['title'].
                    '</div>
                    <div class="panel-body">'
                    .$row['description'].
                    '<br />
					<hr />'
					.$tags_output.
					'<hr />
					<a href="'.$row['url'].'" target="_blank" class="btn btn-primary btn-lg">Aller</a>
                    </div>
                    </div>';
        }
        
    }
    catch(PDOException $e)
    {