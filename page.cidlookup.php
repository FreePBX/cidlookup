<?php /* $Id */
//Copyright (C) 2006 WeBRainstorm S.r.l. (ask@webrainstorm.it)
//
//This program is free software; you can redistribute it and/or
//modify it under the terms of the GNU General Public License
//as published by the Free Software Foundation; either version 2
//of the License, or (at your option) any later version.
//
//This program is distributed in the hope that it will be useful,
//but WITHOUT ANY WARRANTY; without even the implied warranty of
//MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//GNU General Public License for more details.

isset($_REQUEST['action'])?$action = $_REQUEST['action']:$action='';

//the item we are currently displaying
isset($_REQUEST['itemid'])?$itemid=$_REQUEST['itemid']:$itemid='';

$dispnum = "cidlookup"; //used for switch on config.php

//if submitting form, update database
if(isset($_POST['action'])) {
	switch ($action) {
		case "add":
			cidlookup_add($_POST);
			needreload();
			redirect_standard();
		break;
		case "delete":
			cidlookup_del($itemid);
			needreload();
			redirect_standard();
		break;
		case "edit":
			cidlookup_edit($itemid,$_POST);
			needreload();
			redirect_standard('itemid');
		break;
	}
}

//get list of callerid lookup sources
$cidsources = cidlookup_list();
?>

</div> <!-- end content div so we can display rnav properly-->

<!-- right side menu -->
<div class="rnav"><ul>
    <li><a id="<?php echo ($itemid=='' ? 'current':'') ?>" href="config.php?display=<?php echo urlencode($dispnum)?>"><?php echo _("Add CID Lookup Source")?></a></li>
<?php
if (isset($cidsources)) {
	foreach ($cidsources as $cidsource) {
		if ($cidsource['cidlookup_id'] != 0)
			echo "<li><a id=\"".($itemid==$cidsource['cidlookup_id'] ? 'current':'')."\" href=\"config.php?display=".urlencode($dispnum)."&itemid=".urlencode($cidsource['cidlookup_id'])."\">{$cidsource['description']}</a></li>";
	}
}
?>
</ul></div>

<div class="content">
<?php
if ($action == 'delete') {
	echo '<br><h3>'._("CID Lookup source").' '.$itemid.' '._("deleted").'!</h3>';
} else {
	if ($itemid){ 
		//get details for this source
		$thisItem = cidlookup_get($itemid);
	} else {
		$thisItem = Array( 'description' => null, 'sourcetype' => null, 'cache' => null);
	}

	$delURL = $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'].'&action=delete';
	$delButton = "
			<form name=delete action=\"{$_SERVER['PHP_SELF']}\" method=POST>
				<input type=\"hidden\" name=\"display\" value=\"{$dispnum}\">
				<input type=\"hidden\" name=\"itemid\" value=\"{$itemid}\">
				<input type=\"hidden\" name=\"action\" value=\"delete\">
				<input type=submit value=\""._("Delete CID Lookup source")."\">
			</form>";
	
?>

	<h2><?php echo ($itemid ? _("Source:")." ". $itemid : _("Add Source")); ?></h2>
	
	<p style="width: 80%"><?php echo ($itemid ? '' : _("A Lookup Source let you specify a source for resolving numeric caller IDs of incoming calls, you can then link an Inbound route to a specific CID source. This way you will have more detailed CDR reports with informations taken directly from your CRM. You can also install the phonebook module to have a small number <-> name association. Pay attention, name lookup may slow down your PBX")); ?></p>

<?php		if ($itemid){  echo $delButton; 	} ?>

<form autocomplete="off" name="edit" action="<?php $_SERVER['PHP_SELF'] ?>" method="post" onsubmit="return edit_onsubmit();">
	<input type="hidden" name="display" value="<?php echo $dispnum?>">
	<input type="hidden" name="action" value="<?php echo ($itemid ? 'edit' : 'add') ?>">
	<input type="hidden" name="deptname" value="<?php echo $_SESSION["AMP_user"]->_deptname ?>">
	<table>
	<tr><td colspan="2"><h5><?php echo ($itemid ? _("Edit Source") : _("Add Source")) ?><hr></h5></td></tr>

<?php		if ($itemid){ ?>
		<input type="hidden" name="itemid" value="<?php echo $itemid; ?>">
<?php		}?>

	<tr>
		<td><a href="#" class="info"><?php echo _("Source Description:")?><span><?php echo _("Enter a description for this source.")?></span></a></td>
		<td><input type="text" name="description" value="<?php echo (isset($thisItem['description']) ? $thisItem['description'] : ''); ?>"></td>
	</tr>
	<tr>
		<td><a href="#" class="info"><?php echo _("Source type:")?><span><?php echo _("Enter the source type, you can choose beetwen:<ul><li>Internal: use astdb as lookup source, use phonebook module to populate it</li><li>ENUM: Use DNS to lookup caller names, it uses ENUM lookup zones as configured in enum.conf</li><li>HTTP: It executes an HTTP GET passing the caller number as argument to retrieve the correct name</li><li>MySQL: It queryes a MySQL database to retrieve caller name</li></ul>")?></span></a></td>
		<td>
			<select id="sourcetype" name="sourcetype" onChange="javascript:displaySourceParameters(this, this.selectedIndex)">
				<option value="internal" <?php echo ($thisItem['sourcetype'] == 'internal' ? 'selected' : '')?>>Internal</option>
				<option value="enum" <?php echo ($thisItem['sourcetype'] == 'enum' ? 'selected' : '')?>>ENUM</option>
				<option value="http" <?php echo ($thisItem['sourcetype'] == 'http' ? 'selected' : '')?>>HTTP</option>
				<option value="mysql" <?php echo ($thisItem['sourcetype'] == 'mysql' ? 'selected' : '')?>>MySQL</option>
				<option value="sugarcrm" <?php echo ($thisItem['sourcetype'] == 'sugarcrm' ? 'selected' : '')?>>SugarCRM</option>
			</select>
		</td>
	</tr>
	<tr>
		<td><a href="#" class="info"><?php echo _("Cache results:")?><span><?php echo _("Decide wether or not cache the results to astDB; it will overwrite present values. It does not affect Internal source behaviour")?></span></a></td>
		<td><input type="checkbox" name="cache" value="1" <?php echo ($thisItem['cache'] == 1 ? 'checked' : ''); ?>"></td>
	</tr>
	<tr>
		<td colspan="2">
			<div id="http" style="display: none">
				<table cellpadding="2" cellspacing="0" width="100%">

					<tr><td colspan="2"><h5><?php echo _("HTTP") ?><hr></h5></div></td></tr>
	
					<tr>
						<td width="50%"><a href="#" class="info"><?php echo _("Host:")?><span><?php echo _("Host name or IP address")?></span></a></td>
						<td><input type="text" name="http_host" value="<?php echo (isset($thisItem['http_host']) ? $thisItem['http_host'] : ''); ?>"></td>
					</tr>
	
					<tr>
						<td><a href="#" class="info"><?php echo _("Port:")?><span><?php echo _("Port HTTP server is listening at (default 80)")?></span></a></td>
						<td><input type="text" name="http_port" value="<?php echo (isset($thisItem['http_port']) ? $thisItem['http_port'] : ''); ?>"></td>
					</tr>
					
					<tr>
						<td><a href="#" class="info"><?php echo _("Username:")?><span><?php echo _("Username to use in HTTP authentication")?></span></a></td>
						<td><input type="text" name="http_username" value="<?php echo (isset($thisItem['http_username']) ? $thisItem['http_username'] : ''); ?>"></td>
					</tr>
				
					<tr>
						<td><a href="#" class="info"><?php echo _("Password:")?><span><?php echo _("Password to use in HTTP authentication")?></span></a></td>
						<td><input type="text" name="http_password" value="<?php echo (isset($thisItem['http_password']) ? $thisItem['http_password'] : ''); ?>"></td>
					</tr>
				
					<tr>
						<td><a href="#" class="info"><?php echo _("Path:")?><span><?php echo _("Path of the file to GET<br/>e.g.: /cidlookup.php")?></span></a></td>
						<td><input type="text" name="http_path" value="<?php echo (isset($thisItem['http_path']) ? $thisItem['http_path'] : ''); ?>"></td>
					</tr>
				
					<tr>
						<td><a href="#" class="info"><?php echo _("Query:")?><span><?php echo _("Query string, special token '[NUMBER]' will be replaced with caller number<br/>e.g.: number=[NUMBER]&source=crm")?></span></a></td>
						<td><input type="text" name="http_query" value="<?php echo (isset($thisItem['http_query']) ? $thisItem['http_query'] : ''); ?>"></td>
					</tr>
				</table>
			</div>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<div id="mysql" style="display: none">
				<table cellpadding="2" cellspacing="0" width="100%">
					<tr><td colspan="2"><h5><?php echo _("MySQL") ?><hr></h5></td></tr>
				
					<tr>
						<td width="50%"><a href="#" class="info"><?php echo _("Host:")?><span><?php echo _("MySQL Host")?></span></a></td>
						<td><input type="text" name="mysql_host" value="<?php echo (isset($thisItem['mysql_host']) ? $thisItem['mysql_host'] : ''); ?>"></td>
					</tr>
					<tr>
						<td><a href="#" class="info"><?php echo _("Database:")?><span><?php echo _("Database name")?></span></a></td>
						<td><input type="text" name="mysql_dbname" value="<?php echo (isset($thisItem['mysql_dbname']) ? $thisItem['mysql_dbname'] : ''); ?>"></td>
					</tr>
					<tr>
						<td><a href="#" class="info"><?php echo _("Query:")?><span><?php echo _("Query, special token '[NUMBER]' will be replaced with caller number<br/>e.g.: SELECT name FROM phonebook WHERE number LIKE '%[NUMBER]%'")?></span></a></td>
						<td><input type="text" name="mysql_query" value="<?php echo (isset($thisItem['mysql_query']) ? $thisItem['mysql_query'] : ''); ?>"></td>
					</tr>
				
					<tr>
						<td><a href="#" class="info"><?php echo _("Username:")?><span><?php echo _("MySQL Username")?></span></a></td>
						<td><input type="text" name="mysql_username" value="<?php echo (isset($thisItem['mysql_username']) ? $thisItem['mysql_username'] : ''); ?>"></td>
					</tr>
					<tr>
						<td><a href="#" class="info"><?php echo _("Password:")?><span><?php echo _("MySQL Password")?></span></a></td>
						<td><input type="text" name="mysql_password" value="<?php echo (isset($thisItem['mysql_password']) ? $thisItem['mysql_password'] : ''); ?>"></td>
					</tr>
				</table>
			</div>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<div id="sugarcrm" style="display: none">
				<table cellpadding="2" cellspacing="0" width="100%">
				  <tr><td colspan="2"><h5><?php echo _("SugarCRM") ?><hr></h5></td></tr>
				  <tr><td colspan="2">Not yet implemented</td></tr>
				</table>
			</div>
		</td>
	</tr>

	<tr>
		<td colspan="2"><br><h6><input name="submit" type="submit" value="<?php echo _("Submit Changes")?>"></h6></td>		
	</tr>
	</table>


<script language="javascript">
<!--

/* TODO: improve client side checking for different values of sourcetype */

var theForm = document.edit;
theForm.description.focus();

displaySourceParameters(document.getElementById('sourcetype'), document.getElementById('sourcetype').selectedIndex);

function edit_onsubmit() {
		
	defaultEmptyOK = false;
	if (!isAlphanumeric(theForm.description.value))
		return warnInvalid(theForm.description, "Please enter a valid Description");

	if (theForm.sourcetype.value == 'http')	{
		if (isEmpty(theForm.http_host.value))
			return warnInvalid(theForm.http_host, "Please enter a valid HTTP Host name");
	}

	if (theForm.sourcetype.value == 'mysql')	{
		if (isEmpty(theForm.mysql_host.value))
			return warnInvalid(theForm.mysql_host, "Please enter a valid MySQL Host name");

		if (isEmpty(theForm.mysql_dbname.value))
			return warnInvalid(theForm.mysql_dbname, "Please enter a valid MySQL Database name");
			
		if (isEmpty(theForm.mysql_query.value))
			return warnInvalid(theForm.mysql_query, "Please enter a valid MySQL Query string");

		if (isEmpty(theForm.mysql_username.value))
			return warnInvalid(theForm.mysql_username, "Please enter a valid MySQL Username");

	}
			
	return true;
}

function displaySourceParameters(sourcetypeSelect, key) {
	if (sourcetypeSelect.options[key].value == 'http') {
		document.getElementById('http').style.display = '';
		document.getElementById('mysql').style.display = 'none';
		document.getElementById('sugarcrm').style.display = 'none';
	} else if (sourcetypeSelect.options[key].value == 'mysql') {
		document.getElementById('http').style.display = 'none';
		document.getElementById('mysql').style.display = '';
		document.getElementById('sugarcrm').style.display = 'none';
	} else if (sourcetypeSelect.options[key].value == 'sugarcrm') {
		document.getElementById('http').style.display = 'none';
		document.getElementById('mysql').style.display = 'none';
		document.getElementById('sugarcrm').style.display = '';
	} else {
		document.getElementById('http').style.display = 'none';
		document.getElementById('mysql').style.display = 'none';
		document.getElementById('sugarcrm').style.display = 'none';
	}
}
-->
</script>


	</form>
<?php		
} //end if action == delete
?>
