<?php
//    License for all code of this FreePBX module can be found in the license file inside the module directory
//    Copyright 2015 Sangoma Technologies.
$cidsources = cidlookup_list();
$srow = "";
foreach ($cidsources as $source) {
    if($source['sourcetype'] === null){
      continue;
    }
    $srow .= '<tr>';
    $srow .= '<td>'.$source['description'].'</td>';
    $srow .= '<td>';
    if ($source['sourcetype'] == 'opencnam') {
        $srow .= 'OpenCNAM';
    } else {
        $srow .= $source['sourcetype'];
    }
    $srow .= '</td>';
    $srow .= '<td><a href="?display=cidlookup&view=form&itemid='.$source['cidlookup_id'].'&amp;extdisplay='.$source['cidlookup_id'].'"><i class="fa fa-edit"></i></a>';
    $srow .= '&nbsp;';
    $srow .= '<a href="config.php?display=cidlookup&view=form&amp;itemid='.$source['cidlookup_id'].'&amp;action=delete"><i class="fa fa-trash"></i></a>';
    $srow .= '</td></tr>';
}
?>
<div id="toolbar-all">
  <a href="config.php?display=cidlookup&amp;view=form" class="btn btn-default" ><i class="fa fa-plus"></i>&nbsp; <?php echo _("Add CIDLookup Source") ?></a>

</div>
<table id="cidlookupgrid"
        data-cache="false"
        data-toolbar="#toolbar-all"
        data-toggle="table"
        data-pagination="true"
        data-search="true"
        class="table table-striped">
<thead>
    <tr>
        <th data-sortable="true"><?php echo _("Description")?></th>
        <th data-sortable="true"><?php echo _("Type")?></th>
        <th><?php echo _("Actions")?></th>
    </tr>
</thead>
<tbody>
    <?php echo $srow ?>
</tbody>
</table>
