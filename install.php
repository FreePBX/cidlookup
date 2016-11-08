<?php
if (!defined('FREEPBX_IS_AUTH')) { die('No direct script access allowed'); }

global $db;
global $amp_conf;
$dbh = \FreePBX::Database();
$cidlookup = $dbh->migrate("cidlookup");
$cidlookup_incoming = $dbh->migrate("cidlookup_incoming");

$cidlookup_cols = array(
	"cidlookup_id" => array(
		"type" => "integer",
		"primaryKey" => true,
		"notnull" => true,
		"autoincrement" => true
	),
	"description" => array(
		"type" => "string",
		"length" => 50,
		"notnull" => true,
	),
	"sourcetype" => array(
		"type" => "string",
		"length" => 100,
		"notnull" => true,
	),
	"cache" => array(
		"type" => "smallint",
		"length" => 1,
		"notnull" => true,
		"default" => 0
	),
	"deptname" => array(
		"type" => "string",
		"length" => 30,
		"notnull" => false,
	),
	"http_host" => array(
		"type" => "string",
		"length" => 100,
		"notnull" => false
	),
	"http_port" => array(
		"type" => "string",
		"length" => 30,
		"notnull" => false
	),
	"http_username" => array(
		"type" => "string",
		"length" => 50,
		"notnull" => false
	),
	"http_password" => array(
		"type" => "string",
		"length" => 50,
		"notnull" => false
	),
	"http_path" => array(
		"type" => "string",
		"length" => 100,
		"notnull" => false
	),
	"http_query" => array(
		"type" => "string",
		"length" => 100,
		"notnull" => false
	),
	"mysql_host" => array(
		"type" => "string",
		"length" => 60,
		"notnull" => false
	),
	"mysql_dbname" => array(
		"type" => "string",
		"length" => 60,
		"notnull" => false
	),
	"mysql_query" => array(
		"type" => "string",
		"notnull" => false
	),
	"mysql_username" => array(
		"type" => "string",
		"length" => 30,
		"notnull" => false
	),
	"mysql_password" => array(
		"type" => "string",
		"length" => 30,
		"notnull" => false
	),
	"mysql_charset" => array(
		"type" => "string",
		"length" => 60,
		"notnull" => false
	),
	"opencnam_account_sid" => array(
		"type" => "string",
		"length" => 34,
		"notnull" => false
	),
	"opencnam_auth_token" => array(
		"type" => "string",
		"length" => 34,
		"notnull" => false
	),
	"cm_group" => array(
		"type" => "string",
		"length" => 5,
		"notnull" => false,
		"default" => ''
	),
	"cm_format" => array(
		"type" => "string",
		"length" => 5,
		"notnull" => false,
		"default" => ''
	)
);
outn(_("Processing Database Tables"));
$cidlookup->modify($cidlookup_cols);
unset($cidlookup);

$cidlookup_incoming_cols = array(
	"cidlookup_id" => array(
		"type" => "integer",
		"notnull" => true,
	),
	"extension" => array(
		"type" => "string",
		"length" => 50,
		"notnull" => false,
	),
	"cidnum" => array(
		"type" => "string",
		"length" => 30,
		"notnull" => false,
	)
);
$cidlookup_incoming->modify($cidlookup_incoming_cols);
unset($cidlookup_incoming);


outn(_("Migrating channel routing to Zap DID routing.."));
$sql = "SELECT channel FROM cidlookup_incoming";
$check = @$db->query($sql);
if (!DB::IsError($check)) {
	$chan_prefix = 'zapchan';
	$sql = "UPDATE cidlookup_incoming SET extension=CONCAT('$chan_prefix',channel), channel='' WHERE channel != ''";
	$results = $db->query($sql);
	if (DB::IsError($results)) {
 		out(_("FATAL: failed to transform old routes: ").$results->getMessage());
	} else {
		out(_("OK"));
		// ALTER...DROP is not supported by sqlite3.  This table was setup properly in the CREATE anyway
		if($amp_conf["AMPDBENGINE"] != "sqlite3")  {
			outn(_("Removing deprecated channel field from incoming.."));
			$sql = "ALTER TABLE cidlookup_incoming DROP channel";
			$results = $db->query($sql);
			if (DB::IsError($results)) {
 			out(_("ERROR: failed: ").$results->getMessage());
			} else {
				out(_("OK"));
			}
		}
	}
} else {
	out(_("Not Needed"));
}

// This field had been wrongfully added to incoming quite some time ago
// this should maybe be added to core as well.
// NOTE: ALTER / DROP isn't supported in SQLite3 prior to 3.1.3.
outn(_("Checking for cidlookup field in core's incoming table.."));
$sql = "ALTER TABLE incoming DROP cidlookup";
$results = $db->query($sql);
if (DB::IsError($results)) {
	out(_("not present"));
} else {
	out(_("removed"));
}


//Sanatize dids....
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
