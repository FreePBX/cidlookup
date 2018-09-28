<!--cidlookup hook -->
<!--CID Lookup Source-->
<div class="element-container">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="form-group">
					<div class="col-md-3">
						<label class="control-label" for="cidlookup_id"> <?php echo _("CID Lookup Source")?></label>
						<i class="fa fa-question-circle fpbx-help-icon" data-for="cidlookup_id"></i>
					</div>
					<div class="col-md-9">
						<select name="cidlookup_id" id="cidlookup_id" class="form-control" onChange="javascript:openCNAMNoteDisplay(this, this.selectedIndex)">
							<?php echo $didIdOptions ?>
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<span id="cidlookup_id-help" class="help-block fpbx-help-block"><?php echo _("Sources can be added in Caller Name Lookup Sources section")?></span>
		</div>
	</div>
</div>
<!--END CID Lookup Source-->
<!--END cidlookup hook-->