<?php
namespace FreePBX\modules;
if (!defined('FREEPBX_IS_AUTH')) { die('No direct script access allowed'); }
//	License for all code of this FreePBX module can be found in the license file inside the module directory
//	Copyright 2015 Sangoma Technologies.
//
class Cidlookup implements \BMO {
	public function __construct($freepbx = null) {
		if ($freepbx == null) {
			throw new Exception("Not given a FreePBX Object");
		}
		$this->FreePBX = $freepbx;
		$this->database = $freepbx->Database;
		//Get Future Module information (This is only used for a few things right now)
		$this->cid_modules = array();
		foreach (glob(__DIR__."/modules/*",GLOB_ONLYDIR) as $filename) {
 			 $this->cid_modules[] = basename($filename);
		}
	}
		public function install() {}
		public function uninstall() {}
		public function backup() {}
		public function restore($backup) {}
		public function doConfigPageInit($page) {
			$request = $_REQUEST;
		isset($request['action']) ? ($action = $request['action']) : $action='';
		isset($request['view']) ? ($view = $request['view']) : $view = 'form';
		isset($request['itemid']) ? ($itemid = $request['itemid']) : $itemid='';
		if(isset($request['action'])) {
			switch ($action) {
				case "add":
					cidlookup_add($request);
					needreload();
					redirect_standard();
				break;
				case "delete":
					cidlookup_del($itemid);
					needreload();
					redirect_standard();
				break;
				case "edit":
					cidlookup_edit($itemid,$request);
					needreload();
					redirect_standard('itemid');
				break;
				case "getJSON":
					switch($request['jdata']){
						case "cid_modules":
							header('Content-Type: application/json');
							echo json_encode($this->cid_modules);
							exit();
						break;
						default:
							header('Content-Type: application/json');
							echo json_encode(array('status' => 'ERROR', 'message' => 'Invalid Request'));
							exit();
						break;
					}
				break;
			}
		}
		}
			public function getActionBar($request){
		switch($request['display']){
			case 'cidlookup':
				$buttons = array(
					'delete' => array(
						'name' => 'delete',
						'id' => 'delete',
						'value' => _('Delete')
					),
					'submit' => array(
						'name' => 'submit',
						'id' => 'submit',
						'value' => _('Submit')
					),
					'reset' => array(
						'name' => 'reset',
						'id' => 'reset',
						'value' => _('Reset')
					)
					);
				break;
			}
			if (empty($request['extdisplay']) || $request['extdisplay'] == "") {
				unset($buttons['delete']);
			}
			if(empty($request['view']) || $request['view'] != 'form'){
				$buttons = array();
			}
			return $buttons;
		}
		public function getRightNav($request){
			if(isset($request['view'])){
				return load_view(__DIR__.'/views/bootnav.php');
			}
		}
		function getList($all=false) {
			$allowed = array(array('cidlookup_id' => 0, 'description' => _("None"), 'sourcetype' => null));
			$sql = "SELECT * FROM cidlookup";
			$stmt = $this->database->prepare($sql);
			$stmt->execute();
			$results = $stmt->fetchall(\PDO::FETCH_ASSOC);
			if(is_array($results)){
				foreach ($results as $key => $value) {
					$allowed[] = $value;
				}
			}
			return $allowed;
		}
		public function ajaxRequest($req, &$setting) {
			 switch ($req) {
					 case 'getJSON':
							 return true;
					 break;
					 default:
							 return false;
					 break;
			 }
	 }
	public function ajaxHandler(){
		switch ($_REQUEST['command']) {
			case 'getJSON':
				switch ($_REQUEST['jdata']) {
					case 'grid':
						$items = $this->getList();
						unset($items[0]);
						return array_values($items);
					break;
					default:
						return false;
					break;
				}
			break;
			default:
				return false;
			break;
		}
	}
}
