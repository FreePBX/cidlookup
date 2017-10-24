<?php
if (!defined('FREEPBX_IS_AUTH')) { die('No direct script access allowed'); }

global $db;
global $amp_conf;
$dbh = \FreePBX::Database();

//Sanitize dids....
out("Checking for DID entries with invalid data");
$sql = 'select * from cidlookup_incoming where cidnum like "<%>"';
$stmt = $dbh->prepare($sql);
$stmt->execute();
$entries = $stmt->fetchAll(\PDO::FETCH_ASSOC);
$didupdates = array();
foreach($entries as $e){
	$invalidDIDChars = array('<', '>');
	 $val = trim(str_replace($invalidDIDChars, "", $e['cidnum']));
	 if($val !== $e['cidnum']){
		 $didupdates[] = array(':cidlookup_id' => $e['cidlookup_id'], ':cidnum' => $val, ':extension' => $e['extension']);
	 }
}
$sql = 'UPDATE cidlookup_incoming SET cidnum = :cidnum WHERE cidlookup_id = :cidlookup_id AND extension = :extension';
$stmt = $dbh->prepare($sql);
if(empty($didupdates)){
	out("No bad data found");
}else{
	out("Sanatizing dids");
}
foreach ($didupdates as $d) {
	$stmt->execute($d);
}
