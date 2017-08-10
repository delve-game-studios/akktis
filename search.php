<?php

require_once 'adodb5/adodb.inc.php';


$query = !empty($_GET['q']) ? $_GET['q'] : false;

$db = ADONewConnection('mysqli');
$db->SetFetchMode(ADODB_FETCH_ASSOC);
$db->Connect('localhost', 'root', '', 'akktis');

$sql = 'SELECT u.*, c.name as color FROM `users` AS u LEFT JOIN `colors` AS c ON u.color_id = c.id';

if($query) {
	$sql .= sprintf(' WHERE u.firstName LIKE %s OR u.lastName LIKE %s', "'%{$query}%'", "'%{$query}%'");
}

$rs = $db->GetAll($sql);

header('Content-Type: application/json');

echo json_encode([
	'data' => $rs
]);

?>