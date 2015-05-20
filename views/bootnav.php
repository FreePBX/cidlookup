<?php
//	License for all code of this FreePBX module can be found in the license file inside the module directory
//	Copyright 2015 Sangoma Technologies.
//?>
<a href="config.php?display=cidlookup" class="list-group-item <?php echo (!empty($request['view']) && $request['view'] == ''? 'hidden':'')?>"><i class="fa fa-list"></i>&nbsp; <?php echo _("List CIDLookup Sources") ?></a>
<a href="config.php?display=cidlookup&amp;view=form" class="list-group-item <?php echo (!empty($request['view']) && $request['view'] == 'form'? 'hidden':'')?>" ><i class="fa fa-plus"></i>&nbsp; <?php echo _("Add CIDLookup Source") ?></a>
