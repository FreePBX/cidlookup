<?php /* $Id */
if (!defined('FREEPBX_IS_AUTH')) { die('No direct script access allowed'); }
//	License for all code of this FreePBX module can be found in the license file inside the module directory
//	Copyright 2013 Schmooze Com Inc.
//	Copyright (C) 2006 WeBRainstorm S.r.l. (ask@webrainstorm.it)

include __DIR__.'/deprecated.functions.php';

function cidlookup_hook_core($viewing_itemid, $target_menuid) {
	if('did' == $target_menuid){
		$vars['didIdOptions'] = '';
		$sources = FreePBX::Cidlookup()->getList();
		$current = cidlookup_did_get($viewing_itemid);
		foreach ($sources as $source) {
			$vars['didIdOptions'] .= sprintf('<option value="%d" %s>%s</option>', $source['cidlookup_id'], ($current == $source['cidlookup_id'] ? 'selected' : ''), $source['description']);
		}

		return load_view(__DIR__.'/views/coreDIDHook.php',$vars);
	}
}

function cidlookup_hookProcess_core($viewing_itemid, $request) {
	$cidlookup = FreePBX::Cidlookup();
	if (!isset($request['action']))
		return;
	switch ($request['action']) {
		case 'addIncoming':
			$invalidDIDChars = array('<', '>');
			$extension = trim(str_replace($invalidDIDChars, "", $request['extension']));
			$cidnum = trim(str_replace($invalidDIDChars, "", $request['cidnum']));
			$cidlookup->didAdd($request['cidlookup_id'], $extension, $cidnum);
			break;
		case 'delIncoming':
			$extarray = explode('/', $request['extdisplay'], 2);
			$cidlookup->didDelete($extarray[0], $extarray[1]);
			break;
		case 'edtIncoming':		 // deleting and adding as in core module
			$extarray = explode('/', $request['extdisplay'], 2);
			$invalidDIDChars = array('<', '>');
			$extension = trim(str_replace($invalidDIDChars, "", $request['extension']));
			$cidnum = trim(str_replace($invalidDIDChars, "", $request['cidnum']));
			$cidlookup->didDelete($extarray[0], $extarray[1]);
			$cidlookup->didAdd($request['cidlookup_id'], $extension, $cidnum);
			break;
	}
}


/*
 *	Generates dialplan for cidlookup
 *	We call this with retrieve_conf
*/

function cidlookup_get_config($engine) {
	global $ext;	// is this the best way to pass this?
	global $asterisk_conf;
	global $version;
	switch($engine) {
		case "asterisk":
			$sources = FreePBX::Cidlookup()->getList(true);
			if(is_array($sources)) {
				foreach($sources as $item) {

					// Search for number in the cache, if found lookupcidnum and return
					if ($item['cidlookup_id'] != 0)	{
						if ($item['cache'] == 1 && $item['sourcetype'] != 'internal' && $item['sourcetype'] != 'opencnam') {
							$ext->add('cidlookup', 'cidlookup_'.$item['cidlookup_id'], '', new ext_gotoif('$[${DB_EXISTS(cidname/${CALLERID(num)})} = 1]', 'cidlookup,cidlookup_return,1'));
						}
					}

					switch($item['sourcetype']) {

						case "internal":
							$ext->add('cidlookup', 'cidlookup_'.$item['cidlookup_id'], '', new ext_lookupcidname(''));
						break;

						case "enum":
							$ext->add('cidlookup', 'cidlookup_'.$item['cidlookup_id'], '', new ext_setvar('CALLERID(name)', '${TXTCIDNAME(${CALLERID(num)})}'));


						break;

						case "contactmanager":
							$ext->add('cidlookup', 'cidlookup_'.$item['cidlookup_id'], '', new ext_agi('contactmanager.agi, ${CALLERID(num)},'.$item['cm_group'].','.$item['cm_format']));
							$ext->add('cidlookup', 'cidlookup_'.$item['cidlookup_id'], '', new ext_execif('$["${CMCID}" != "Unknown"]','Set','CALLERID(name)='.'${CMCID}'));

						break;

						case "opencnam":
							if (!empty($item['opencnam_account_sid']) && !empty($item['opencnam_auth_token'])) {
								$auth = sprintf('%s:%s@', urlencode($item['opencnam_account_sid']), urlencode($item['opencnam_auth_token']));
							} else {
								$nt = \notifications::create();
								$rawname = 'cidlookup';
								$uid = 'noauth';
								if(!$nt->exists($rawname, $uid)) {
									$nt->add_warning($rawname, $uid, _("OpenCNAM Requires Authentication"), _("Unauthenticated calls to the OpenCNAM API will soon fail. You will need an OpenCNAM account to continue using their API"), "https://opencnam.com", true, true);
								}
								$auth = '';
							}

							$url = sprintf('https://%sapi.opencnam.com/v2/phone/${CALLERID(num)}?format=pbx&ref=freepbx', $auth);
							$curl = sprintf('${CURL(%s)}', $url);

							$ext->add('cidlookup', 'cidlookup_'.$item['cidlookup_id'], '', new ext_set('CURLOPT(httptimeout)', '7'));
							$ext->add('cidlookup', 'cidlookup_'.$item['cidlookup_id'], '', new ext_set('CALLERID(name)', $curl));

							// If the user is using the OpenCNAM Hobbyist Tier,
							// track hourly query stats--this allows us to alert
							// the user if they go past their free usage limits
							// and need to upgrade their OpenCNAM plan.
							if (!$auth) {
								$ext->add('cidlookup', 'cidlookup_'.$item['cidlookup_id'], '', new ext_set('current_hour', '${STRFTIME(,,%Y-%m-%d %H)}'));
								$ext->add('cidlookup', 'cidlookup_'.$item['cidlookup_id'], '', new ext_set('last_query_hour', '${DB(cidlookup/opencnam_last_query_hour)}'));
								$ext->add('cidlookup', 'cidlookup_'.$item['cidlookup_id'], '', new ext_set('total_hourly_queries', '${DB(cidlookup/opencnam_total_hourly_queries)}'));
								$ext->add('cidlookup', 'cidlookup_'.$item['cidlookup_id'], '', new ext_execif('$["${last_query_hour}" != "${current_hour}"]', 'Set', 'DB(cidlookup/opencnam_total_hourly_queries)=0'));
								$ext->add('cidlookup', 'cidlookup_'.$item['cidlookup_id'], '', new ext_execif('$["${total_hourly_queries}" = ""]', 'Set', 'DB(cidlookup/opencnam_total_hourly_queries)=0'));
								$ext->add('cidlookup', 'cidlookup_'.$item['cidlookup_id'], '', new ext_set('DB(cidlookup/opencnam_total_hourly_queries)', '${MATH(${DB(cidlookup/opencnam_total_hourly_queries)}+1,i)}'));
								$ext->add('cidlookup', 'cidlookup_'.$item['cidlookup_id'], '', new ext_execif('$[${DB(cidlookup/opencnam_total_hourly_queries)} >= 10]', 'System', '${ASTVARLIBDIR}/bin/opencnam-alert.php'));
								$ext->add('cidlookup', 'cidlookup_'.$item['cidlookup_id'], '', new ext_set('DB(cidlookup/opencnam_last_query_hour)', '${current_hour}'));
							}

						break;

						case "https":
						case "http":
							if (!empty($item['http_username']) && !empty($item['http_password']))
								$auth = sprintf('%s:%s@', $item['http_username'], urlencode($item['http_password']));
							else
								$auth = '';

							if (!empty($item['http_port']))
								$host = sprintf('%s:%d', $item['http_host'], $item['http_port']);
							elseif ($item['sourcetype'] == 'https')
								$host = $item['http_host'].':443';
							else
								$host = $item['http_host'].':80';

							if (substr($item['http_path'], 0, 1) == '/')
								$path = substr($item['http_path'], 1);
							else
								$path = $item['http_path'];

							$tempst = array('[NUMBER]','[NAME]','[LANGUAGE]','[UNIQUEID]');
							$values = array('${STRREPLACE(CALLERID(num),"+",%2B)}','${CALLERID(name)}','${CHANNEL(language)}','${UNIQUEID}');
							$query = str_replace($tempst, $values, $item['http_query']);
							$query = empty($query)?'':'?'.$query;
							$path = str_replace($tempst, $values, $item['http_path']);
							$url = sprintf('%s://%s%s/%s%s', $item['sourcetype'],$auth, $host, $path, $query);
							$curl = sprintf('${CURL(%s)}', $url);

							$ext->add('cidlookup', 'cidlookup_'.$item['cidlookup_id'], '', new ext_set('CURLOPT(httptimeout)', '7'));
							$ext->add('cidlookup', 'cidlookup_'.$item['cidlookup_id'], '',new ext_set('CALLERID(name)','${STRREPLACE(CALLERID(name), ,%20)}'));
							$ext->add('cidlookup', 'cidlookup_'.$item['cidlookup_id'], '',new ext_set('CALLERID(name)','${STRREPLACE(CALLERID(name),",",%2C)}'));
							$ext->add('cidlookup', 'cidlookup_'.$item['cidlookup_id'], '', new ext_set('CALLERID(name)', $curl));
						break;

						case "mysql":
							$ext->add('cidlookup', 'cidlookup_'.$item['cidlookup_id'], '', new ext_agi("cidlookup_mysql.agi,".$item['cidlookup_id'].",\${CALLERID(num)}"));
						break;
					}

					// Put numbers in the cache
					if ($item['cidlookup_id'] != 0)	{
						if ($item['cache'] == 1 && $item['sourcetype'] != 'internal') {
							$ext->add('cidlookup', 'cidlookup_'.$item['cidlookup_id'], '', new ext_db_put('cidname', '${CALLERID(num)}', '${CALLERID(name)}' ));
						}
						$ext->add('cidlookup', 'cidlookup_'.$item['cidlookup_id'], '', new ext_return(''));
					}
				}

				$ext->add('cidlookup', 'cidlookup_return', '', new ext_lookupcidname(''));
				$ext->add('cidlookup', 'cidlookup_return', '', new ext_return(''));
			}
		break;
	}
}


function cidlookup_did_get($did){
	$extarray = explode('/', $did, 2);
	$count = count($extarray);
	if(2 !== $count){
		return 0;
	}
	if( 2 === $count){ // differentiate beetween '//' (Any did / any cid and '' empty string)
		$sql = sprintf("SELECT cidlookup_id FROM cidlookup_incoming WHERE extension = '%s' AND cidnum = '%s'", $extarray[0], $extarray[1]);
		$result = sql($sql, "getRow", DB_FETCHMODE_ASSOC);
		if(is_array($result)){
			return $result['cidlookup_id'];
		}
		return null;
	}
}
