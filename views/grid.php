<?php
//    License for all code of this FreePBX module can be found in the license file inside the module directory
//    Copyright 2015 Sangoma Technologies.
$cidsources = cidlookup_list();
$srow = "";
foreach ($cidsources as $source) {
    $srow .= '<tr>';
    $srow .= '<td>'.$source['description'].'</td>';
    $srow .= '<td>'.$source['sourcetype'];
    if ($source['sourcetype'] == 'opencnam' && !empty($source['opencnam_account_sid']) && !empty($source['opencnam_auth_token']) ) {
        $srow .= " Pro ";
    }
    $srow .= '</td>';
    $srow .= '<td><a href="?display=cidlookup&view=form&itemid='.$source['cidlookup_id'].'&amp;extdisplay='.$source['cidlookup_id'].'"><i class="fa fa-edit"></i></a>';
    $srow .= '&nbsp;';
    $srow .= '<a href="config.php?display=cidlookup&view=form&amp;itemid='.$source['cidlookup_id'].'&amp;action=delete"><i class="fa fa-trash"></i></a>';
    $srow .= '</td></tr>';
}
?>
<table class="table table-striped">
<thead>
    <tr>
        <th><?php echo _("Description")?></th>
        <th><?php echo _("Type")?></th>
        <th><?php echo _("Actions")?></th>
    </tr>
</thead>
<tbody>
    <?php echo $srow ?>
</tbody>
</table>
