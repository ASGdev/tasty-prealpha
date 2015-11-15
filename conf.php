<?php
/* Application configuration */
$app_key = "PaBDrIHWweC3seDiFRcbygvwfUCNY4TR";

$app_name = "Tasty";
$administrator_name = "ASGdev";
$administrator_mail = "contact@asgdev.fr";

$db_url = "../data/data.sqlite";
$auth_url = "../data/users.sqlite"; // doesn't work for the moment

$allow_public_access = true;

$allow_authentication = true;
$authentication_mode = "normal"; //shadow: the connection button will be hidden

$allow_search = false;
$allow_search_by_tag = false;
$allow_category_browsing = false;
$allow_collection_browsing = false;
$allow_link_deletion = false;
$allow_sharing = false;
$allow_action = false;
$show_about = true;

/*$public_allow_search = false;
$public_allow_search_by_tag = false;
$public_allow_category_browsing = false;
$public_allow_collection_browsing = false;
$public_allow_link_deletion = false;

$user_allow_search = false;
$user_allow_search_by_tag = false;
$user_allow_category_browsing = false;
$user_allow_collection_browsing = false;*/

$use_tw = false;
$use_fb = false;

$api_enabled = false;
$api_auth_type = "db";

$alexandrie_enabled = false;
$alexandrie_api_url = "http://asgdev.fr/alexandrie/api/";
?>