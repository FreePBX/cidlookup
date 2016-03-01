var cid_modules = {};
$.ajax({
    url: "/admin/config.php?display=cidlookup&action=getJSON&jdata=cid_modules&quietmode=1",
    dataType: 'json',
    success: function(data) {
        cid_modules = data;
    }
});



function edit_onsubmit() {
	defaultEmptyOK = false;
    if (!$.trim($('#form_description').val()).length)
        return warnInvalid($('#form_description'), "Description Can Not Be Blank!");
	if ($('#sourcetype').val() == 'http' || $('#sourcetype').val() == 'https')	{
		if (!$.trim($('#http_host').val()).length)
			return warnInvalid($('#http_host'), "Please enter a valid HTTP(S) Host name");
	}
	if ($('#sourcetype').val() == 'mysql')	{
        if (!$.trim($('#mysql_host').val()).length)
			return warnInvalid($('#mysql_host'), "Please enter a valid MySQL Host name");

        if (!$.trim($('#mysql_dbname').val()).length)
			return warnInvalid($('#mysql_dbname'), "Please enter a valid MySQL Database name");

        if (!$.trim($('#mysql_query').val()).length)
			return warnInvalid($('#mysql_query'), "Please enter a valid MySQL Query string");

        if (!$.trim($('#mysql_username').val()).length)
			return warnInvalid($('#mysql_username'), "Please enter a valid MySQL Username");
	}
	if ($('#sourcetype').val() == 'opencnam')	{
        if (!$.trim($('#opencnam_account_sid').val()).length)
			return warnInvalid($('#opencnam_account_sid'), "Please enter a valid Account SID");

        if (!$.trim($('#opencnam_auth_token').val()).length)
			return warnInvalid($('#opencnam_auth_token'), "Please enter a valid Auth Token");
    }
	return true;
}

$('#sourcetype').focus(function () {
    prev_source = $(this).val();
}).change(function() {
    $('#'+prev_source).hide();
    source = $(this).val();
	source = (source == 'https') ? 'http' : source;
    $('#'+source).show();
    prev_source = source;
    if (source == 'opencnam') {
        $('.opencnam_cache').hide();
    } else {
        $('.opencnam_cache').show();
    }
});

function displayInitalSourceParameters() {
    $.each(cid_modules, function(index, value) {
      $('#'+value).hide();
    });
    source = $('#sourcetype').val();
	source = (source == 'https') ? 'http' : source;
    $('#'+source).show();
}

$(function() {
    $('#form_description').focus();
    $('#form_description').alphanumeric();
    displayInitalSourceParameters();
    // By default, don't display OpenCNAM professional stuff unless needed.
    if($('#sourcetype').val() == 'opencnam') {
        $('.opencnam_cache').hide();
    }
});
