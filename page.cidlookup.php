<?php /* $Id */
//	License for all code of this FreePBX module can be found in the license file inside the module directory
//	Copyright 2015 Sangoma Technologies.
//
if (!defined('FREEPBX_IS_AUTH')) { die('No direct script access allowed'); }
$request = $_REQUEST;
$heading = _("CIDLookup");
$pageinfo = _("A Lookup Source let you specify a source for resolving numeric CallerIDs of incoming calls, you can then link an Inbound route to a specific CID source. This way you will have more detailed CDR reports with information taken directly from your CRM. You can also install the phonebook module to have a small number <-> name association. Pay attention, name lookup may slow down your PBX");
$request['view'] = !empty($request['view']) ? $request['view'] : "";
switch ($request['view']) {
	case 'form':
		$content = load_view(__DIR__.'/views/form.php', array('request' => $request));
	break;

	default:
		$content = load_view(__DIR__.'/views/grid.php', array('request' => $request));
	break;
}

?>
<div class="container-fluid">
	<h1><?php echo $heading ?></h1>
	<div class="well well-info">
		<?php echo $pageinfo ?>
	</div>
	<div class = "display full-border">
		<div class="row">
			<div class="col-sm-12">
				<div class="fpbx-container">
					<div class="display full-border">
						<?php echo $content?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
