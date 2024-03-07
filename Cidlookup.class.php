<?php
namespace FreePBX\modules;
//	License for all code of this FreePBX module can be found in the license file inside the module directory
//	Copyright 2016 Sangoma Technologies.
//
use BMO;
use FreePBX_Helpers;
use PDO;

use ext_gosub;
class Cidlookup extends FreePBX_Helpers implements BMO {
	public static $lookupFields = ['cidlookup_id', 'description', 'sourcetype', 'cache', 'http_host', 'http_port', 'http_username', 'http_password', 'http_path', 'http_query', 'mysql_host', 'mysql_port', 'mysql_dbname', 'mysql_query', 'mysql_username', 'mysql_password', 'mysql_charset', 'opencnam_account_sid', 'opencnam_auth_token', 'cm_group', 'cm_format','deptname'];
	public function install() {}
	public function uninstall() {}
	public function doConfigPageInit($page) {
		$action = isset($_REQUEST['action'])?$_REQUEST['action']:false;
		$view = isset($_REQUEST['view'])?$_REQUEST['view']:false;
		$itemid = isset($_REQUEST['itemid'])?$_REQUEST['itemid']:false;
		if('add' === $action){
			$this->add();
			unset($_REQUEST['view']);
		}
		if('edit' === $action){
			$this->edit($itemid);
			unset($_REQUEST['view']);
		}

		if('delete' === $action){
			$this->delete($itemid);
		}
		if($action !== false){
			needreload();
		}
	}

	public function getActionBar($request){
		if('cidlookup' === $request['display']){
			$buttons = [
				'delete' => [
					'name' => 'delete',
					'id' => 'delete',
					'value' => _('Delete')
				],
				'submit' => [
					'name' => 'submit',
					'id' => 'submit',
					'value' => _('Submit'),
				],
				'reset' => [
					'name' => 'reset',
					'id' => 'reset',
					'value' => _('Reset')
				],
			];
			if (empty($request['extdisplay']) || $request['extdisplay'] == "") {
				unset($buttons['delete']);
			}
			if(empty($request['view']) || 'form' !== $request['view']){
				$buttons = [];
			}
			return $buttons;
		}
	}

	public function myDialplanHooks(){
		return true;
	}

	public function doDialplanHook(&$ext, $engine, $priority){
		$pairing = $this->didList();
		if (is_array($pairing)) {
			foreach ($pairing as $item) {
				if ($item['cidlookup_id'] != 0) {

						// Code from modules/core/functions.inc.php core_get_config inbound routes
					$exten = trim($item['extension']);
					$cidnum = trim($item['cidnum']);

					if ($cidnum != '' && $exten == '') {
						$exten = 's';
						$pricid = ($item['pricid']) ? true : false;
					} else if (($cidnum != '' && $exten != '') || ($cidnum == '' && $exten == '')) {
						$pricid = true;
					} else {
						$pricid = false;
					}
					$context = ($pricid) ? "ext-did-0001" : "ext-did-0002";

					if (function_exists('empty_freepbx')) {
						$exten = (empty_freepbx($exten) ? "s" : $exten);
					} else {
						$exten = (empty($exten) ? "s" : $exten);
					}
					$exten = $exten . (empty($cidnum) ? "" : "/" . $cidnum); //if a CID num is defined, add it

					$ext->splice($context, $exten, 'did-cid-hook', new ext_gosub('1', 'cidlookup_' . $item['cidlookup_id'], 'cidlookup'));
				}
			}
		}
	}

	public function getRightNav($request){
		if(isset($request['view'])){
			return load_view(__DIR__.'/views/bootnav.php');
		}
	}

	public function ajaxRequest($command, &$setting) {
		if('getJSON' === $command){
			return true;
		}
		return false;
	}

	public function ajaxHandler(){
		if('getJSON' === $_GET['command'] && 'cid_modules' === $_GET['jdata']){
			$items = $this->getList();
			unset($items[0]);
			return array_values($items);
		}
		return false;
	}

	public function getList($all = false){
		if($all) {
			$allowed = array();
		} else {
			$allowed = array(array('cidlookup_id' => 0, 'description' => _("None"), 'sourcetype' => null));
		}
		$sql = "SELECT * FROM cidlookup";
		$stmt = $this->Database->prepare($sql);
		$stmt->execute();
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if (is_array($results)) {
			foreach ($results as $key => $value) {
				$allowed[] = $value;
			}
		}
		return $allowed;
	}

	public function add(){
		$insert = $this->getInsert($_REQUEST);
		$sql = "INSERT INTO cidlookup
			(description, sourcetype, cache, http_host, http_port, http_username, http_password, http_path, http_query, mysql_host, mysql_port, mysql_dbname, mysql_query, mysql_username, mysql_password, mysql_charset, opencnam_account_sid, opencnam_auth_token, cm_group, cm_format)
		VALUES
			(:description, :sourcetype, :cache, :http_host, :http_port, :http_username, :http_password, :http_path, :http_query, :mysql_host, :mysql_port, :mysql_dbname, :mysql_query, :mysql_username, :mysql_password, :mysql_charset, :opencnam_account_sid, :opencnam_auth_token, :cm_group, :cm_format)";
		$stmt = $this->Database->prepare($sql);
		$stmt->execute($insert);
		return $this;
	}
	public function upsert($array){
		foreach(self::$lookupFields as $field){
			if(isset($array[$field])){
				continue;
			}
			$array[$field] = '';
		}
		$sql = "REPLACE INTO cidlookup
			(cidlookup_id, description, sourcetype, cache, http_host, http_port, http_username, http_password, http_path, http_query, mysql_host, mysql_port, mysql_dbname, mysql_query, mysql_username, mysql_password, mysql_charset, opencnam_account_sid, opencnam_auth_token, cm_group, cm_format,deptname)
		VALUES
			(:cidlookup_id, :description, :sourcetype, :cache, :http_host, :http_port, :http_username, :http_password, :http_path, :http_query, :mysql_host, :mysql_port, :mysql_dbname, :mysql_query, :mysql_username, :mysql_password, :mysql_charset, :opencnam_account_sid, :opencnam_auth_token, :cm_group, :cm_format,:deptname)";
		$stmt = $this->Database->prepare($sql);
		$stmt->execute($array);
		return $this;
	}

	public function edit($id){
		$insert = $this->getInsert($_REQUEST);
		$insert['id'] = $id;
		$sql = 'UPDATE cidlookup
			SET
				description = :description,
				sourcetype = :sourcetype ,
				cache = :cache,
				http_host = :http_host,
				http_port = :http_port,
				http_username = :http_username,
				http_password = :http_password,
				http_path = :http_path,
				http_query = :http_query,
				mysql_host = :mysql_host,
				mysql_port = :mysql_port,
				mysql_dbname = :mysql_dbname,
				mysql_query = :mysql_query,
				mysql_username = :mysql_username,
				mysql_password	= :mysql_password,
				mysql_charset = :mysql_charset,
				opencnam_account_sid = :opencnam_account_sid,
				opencnam_auth_token = :opencnam_auth_token,
				cm_group = :cm_group,
				cm_format = :cm_format
			WHERE cidlookup_id = :id
			';
			$stmt = $this->Database->prepare($sql);
			$stmt->execute($insert);
			return $this;
	}

	public function delete($id){
		$sql = "DELETE FROM cidlookup WHERE cidlookup_id = :id";
		$this->Database->prepare($sql)
			->execute([':id' => $id]);
		$sql = "DELETE FROM cidlookup_incoming WHERE cidlookup_id = :id";
		$this->Database->prepare($sql)
			->execute([':id' => $id]);
		return $this;
	}

	public function getOne($id)
	{
		$sql = "SELECT * FROM cidlookup WHERE cidlookup_id = :id";
		$stmt = $this->Database->prepare($sql);
		$stmt->execute([':id' => $id]);
		//Legacy behavior
		if ($stmt->rowCount() === 0) {
			return null;
		}
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}


	public function didAdd($cidlookupid, $extension, $cidnum){
		$sql = 'INSERT INTO cidlookup_incoming(cidlookup_id, extension, cidnum) VALUES(:id, :extension, :cidnum)';
		$stmt = $this->Database->prepare($sql);
		$stmt->execute([
			':id' => $cidlookupid,
			':extension' => $extension,
			':cidnum' => $cidnum,
		]);
		return $this;
	}

	public function didDelete($extension, $callerid){
		$sql = "DELETE FROM cidlookup_incoming WHERE extension = :extension AND cidnum = :callerid";
		$stmt = $this->Database->prepare($sql);
		$stmt->execute([
			':extension' => $extension,
			':callerid' => $callerid,
		]);
		return $this;
	}


	public function didList($id = false){
		$sql = "
			SELECT cidlookup_id, a.extension extension, a.cidnum cidnum, pricid FROM cidlookup_incoming a
			INNER JOIN incoming b
			ON a.extension = b.extension AND a.cidnum = b.cidnum
		";

		if ($id !== false && ctype_digit($id)) {
			$sql .= " WHERE cidlookup_id = :id";
		}

		$stmt = $this->Database->prepare($sql);
		if ($id !== false && ctype_digit($id)) {
			$stmt->execute([':id' => $id]);
		}else {
			$stmt->execute();
		}
		//Legacy behavior
		if ($stmt->rowCount() === 0) {
			return null;
		}
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getInsert($request){
		$defaults = [
			"description" => "",
			"sourcetype" => "",
			"http_host" => "",
			"http_port" => "",
			"http_username" => "",
			"http_password" => "",
			"http_path" => "",
			"http_query" => "",
			"mysql_host" => "",
			"mysql_port" => "3306",
			"mysql_dbname" => "",
			"mysql_query" => "",
			"mysql_username" => "",
			"mysql_password" => "",
			"mysql_charset" => "",
			"opencnam_account_sid" => "",
			"opencnam_auth_token" => "",
			"cm_group" => [],
			"cm_format" => "",
			"cache" => 0,
		];
		$final = [];
		foreach ($defaults as $key => $value) {
			$final[$key] = isset($request[$key])?$request[$key]:$value;
		}
		if (is_array($final['cm_group'])) {
			$final['cm_group'] = !empty($final['cm_group']) ? implode('_', $final['cm_group']) : "";
		}
		return $final;
	}
}
