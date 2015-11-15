// Still used ??
<?php
$request_body = file_get_contents('php://input');
parse_str($request_body, $data);

if(isset($data) && isset($type)){
	if($type == "category"){
		$cats = json_decode(file_get_contents('data/categories.json'));
		array_push($cats, $data);
		$cats = json_encode($cats);
		file_put_contents('data/categories.json', $data);
	}
	if($type == "collection"){
		$cats_str = file_get_contents('data/collections.json');
		$cats = json_decode($cats_str);
		array_push($cats, $data);
		$cats = json_encode($cats);
		file_put_contents('data/collections.json', $data);
	}	
}

?>