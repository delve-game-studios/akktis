<?php

require_once 'adodb5/adodb.inc.php';

function search($query = false) {
	$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
	$db = ADONewConnection('mysqli'); # eg 'mysql' or 'postgres'
	$db->SetFetchMode(ADODB_FETCH_ASSOC);
	// $db->debug = true;
	$db->Connect('localhost', 'root', '', 'akktis');
	$sql = 'SELECT u.*, c.name as color FROM `users` AS u LEFT JOIN `colors` AS c ON u.color_id = c.id';
	if($query) {
		$sql .= sprintf(' WHERE u.firstName LIKE %s OR u.lastName LIKE %s', "'%{$query}%'", "'%{$query}%'");
	}
	// var_dump($sql);exit;
	$rs = $db->GetAll($sql);

	return $rs;
}

$query = !empty($_GET['q']) ? $_GET['q'] : false;
header('Content-Type: application/json');
echo json_encode([
	'data' => search($query)
]);

?>