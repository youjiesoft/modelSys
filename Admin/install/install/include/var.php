<?php
$env_items = array();
$dirfile_items = array(
    array('type' => 'dir', 'path' => 'install'),
    array('type' => 'dir', 'path' => '../Admin'),
    array('type' => 'dir', 'path' => '../Public'),
);

$func_items = array(
		array('name' => 'mysql_connect'),
		array('name' => 'fsockopen'),
		array('name' => 'gethostbyname'),
		array('name' => 'file_get_contents'),
		array('name' => 'mb_convert_encoding'),
		array('name' => 'json_encode'),
		array('name' => 'curl_init'),
);