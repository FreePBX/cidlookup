<?php
namespace FreePBX\modules\Cidlookup;
use FreePBX\modules\Backup as Base;
class Backup Extends Base\BackupBase{
  public function runBackup($id,$transaction){
    $configs = [];
    $configs['dids'] = $this->FreePBX->Cidlookup->didList();
    $configs['sources'] = $this->FreePBX->Cidlookup->getList(true);
    $this->addDependency('core');
    $this->addConfigs($configs);
  }
}
