<?php
namespace FreePBX\modules\Cidlookup;
use FreePBX\modules\Backup as Base;
class Restore Extends Base\RestoreBase{
  public function runRestore($jobid){
    $CidLookup = $this->FreePBX->CalleridLookup;
    $configs = $this->getConfigs();
    foreach($configs['dids'] as $did){
      $CidLookup->didAdd($did['cidlookup_id'], $did['extension'], $did['cidnum']);
    }
    foreach($configs['sources'] as $source){
      $CidLookup->upsert($source);
    }
  }
}