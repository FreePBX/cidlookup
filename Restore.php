<?php
namespace FreePBX\modules\Cidlookup;
use FreePBX\modules\Backup as Base;
class Restore Extends Base\RestoreBase{
  public function runRestore($jobid){
    $CidLookup = $this->FreePBX->Cidlookup;
    $configs = reset($this->getConfigs());
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
  public function processLegacy($pdo, $data, $tables, $unknownTables, $tmpfiledir)
  {
    $tables = array_flip($tables + $unknownTables);
    if (!isset($tables['cid_lookup'])) {
      return $this;
    }
    $cb = $this->FreePBX->Cidlookup;
    $cb->setDatabase($pdo);
    $configs['dids'] = $cb->didList();
    $configs['sources'] = $cb->getList();
    $cb->resetDatabase();
    foreach ($configs['dids'] as $did) {
      $cb->didAdd($did['cidlookup_id'], $did['extension'], $did['cidnum']);
    }
    foreach ($configs['sources'] as $source) {
      $cb->upsert($source);
    }
    return $this;
  }
}
