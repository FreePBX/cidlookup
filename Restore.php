<?php
namespace FreePBX\modules\Cidlookup;
use FreePBX\modules\Backup as Base;
class Restore Extends Base\RestoreBase{
	public function runRestore(){
		$CidLookup = $this->FreePBX->Cidlookup;
		$configs = $this->getConfigs();
		if (!empty($configs['dids'])) {
			foreach($configs['dids'] as $did){
				$CidLookup->didAdd($did['cidlookup_id'], $did['extension'], $did['cidnum']);
			}
		}
		if (!empty($configs['sources'])) {
			foreach($configs['sources'] as $source){
				$CidLookup->upsert($source);
			}
		}
	}
	public function processLegacy($pdo, $data, $tables, $unknownTables) {
		$tables = ['cidlookup', 'cidlookup_incoming'];
		foreach($tables as $table) {
			$sth = $pdo->query("SELECT * FROM $table",\PDO::FETCH_ASSOC);
			$res = $sth->fetchAll();
			$this->addDataToTableFromArray($table, $res);
		}
	}
}
