<?php
/**
 * Add page.
 *
 * @package page
 * @version 0.9.0
 * @author Neocrome, Cotonti Team
 * @copyright Copyright (c) Cotonti Team 2008-2010
 * @license BSD License
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('forms');

$id = cot_import('id', 'G', 'INT');
$c = cot_import('c', 'G', 'ALP');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('page', 'any');

/* === Hook === */
foreach (cot_getextplugins('page.add.first') as $pl)
{
	include $pl;
}
/* ===== */
cot_block($usr['auth_write']);

if ($a == 'add')
{
	cot_shield_protect();

	/* === Hook === */
	foreach (cot_getextplugins('page.add.add.first') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$rpage['page_cat'] = cot_import('rpagecat', 'P', 'TXT');
	$rpage['page_key'] = cot_import('rpagekey', 'P', 'TXT');
	$rpage['page_alias'] = cot_import('rpagealias', 'P', 'ALP');
	$rpage['page_title'] = cot_import('rpagetitle', 'P', 'TXT');
	$rpage['page_desc'] = cot_import('rpagedesc', 'P', 'TXT');
	$rpage['page_text'] = cot_import('rpagetext', 'P', 'HTM');
	$rpage['page_author'] = cot_import('rpageauthor', 'P', 'TXT');
	$rpage['page_file'] = intval(cot_import('rpagefile', 'P', 'INT'));
	$rpage['page_url'] = cot_import('rpageurl', 'P', 'TXT');
	$rpage['page_size'] = cot_import('rpagesize', 'P', 'TXT');
	$rpage['page_file'] = ($rpage['page_file'] == 0 && !empty($rpage['page_url'])) ? 1 : $rpage['page_file'];
	$rpage['page_ownerid'] = (int)$usr['id'];

	$rpage['page_date'] = (int)$sys['now_offset'];
	$rpage['page_begin'] = (int)cot_import_date('rpagebegin');
	$rpage['page_expire'] = (int)cot_import_date('rpageexpire');
	$rpage['page_expire'] = ($rpage['page_expire'] <= $rpage['page_begin']) ? $rpage['page_begin'] + 31536000 : $rpage['page_expire'];
		
	// Extra fields
	foreach ($cot_extrafields['pages'] as $row)
	{
		$rpage[$row['field_name']] = cot_import_extrafields('rpage'.$row['field_name'], $row);
	}

	list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('page', $rpage['page_cat']);
	cot_block($usr['auth_write']);

	if (empty($rpage['page_cat'])) cot_error('page_catmissing', 'rpagecat');
	if (mb_strlen($rpage['page_title']) < 2) cot_error('page_titletooshort', 'rpagetitle');

	/* === Hook === */
	foreach (cot_getextplugins('page.add.add.error') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if (!$cot_error)
	{
		if (!empty($rpage['page_alias']))
		{
			$sql = $db->query("SELECT page_id FROM $db_pages WHERE page_alias='".$db->prep($rpage['page_alias'])."'");
			$rpage['page_alias'] = ($sql->rowCount() > 0) ? $rpage['page_alias'].rand(1000, 9999) : $rpage['page_alias'];
		}

		if ($usr['isadmin'] && $cfg['page']['autovalidate'])
		{
			$rpublish = cot_import('rpublish', 'P', 'ALP');
			if ($rpublish == 'OK')
			{
				$rpage['page_state'] = 0;
				$db->query("UPDATE $db_structure SET structure_count=structure_count+1 WHERE structure_code='".$db->prep($rpage['page_cat'])."' ");
			}
			else
			{
				$rpage['page_state'] = 1;
			}
		}
		else
		{
			$rpage['page_state'] = 1;
		}

		/* === Hook === */
		foreach (cot_getextplugins('page.add.add.query') as $pl)
		{
			include $pl;
		}
		/* ===== */

		$sql = $db->insert($db_pages, $rpage);
		$id = $db->lastInsertId();
		$r_url = (!$rpage['page_state']) ? cot_url('page', "id=".$id, '', true) : cot_url('message', "msg=300", '', true);

		/* === Hook === */
		foreach (cot_getextplugins('page.add.add.done') as $pl)
		{
			include $pl;
		}
		/* ===== */

		if ($rpage['page_state'] == 0 && $cache)
		{
			if ($cfg['cache_page'])
			{
				$cache->page->clear('page/' . str_replace('.', '/', $cot_cat[$rpage['page_cat']]['path']));
			}
			if ($cfg['cache_index'])
			{
				$cache->page->clear('index');
			}
		}
		cot_shield_update(30, "r page");
		cot_redirect($r_url);
	}
	else
	{
		cot_redirect(cot_url('page', 'm=add', '', true));
	}
}

if (empty($rpage['page_cat']) && !empty($c))
{
	$rpage['page_cat'] = $c;
	$usr['isadmin'] = cot_auth('page', $rpage['page_cat'], 'A');
}

$title_params = array(
	'TITLE' => $L['page_addsubtitle'],
	'CATEGORY' => $cot_cat[$c]['title']
);

$out['subtitle'] = cot_title('title_page', $title_params);
$out['head'] .= $R['code_noindex'];
$sys['sublocation'] = $cot_cat[$c]['title'];

/* === Hook === */
foreach (cot_getextplugins('page.add.main') as $pl)
{
	include $pl;
}
/* ===== */

require_once $cfg['system_dir'].'/header.php';

$mskin = cot_tplfile(array('page', 'add', $cot_cat[$rpage['page_cat']]['tpl']));
$t = new XTemplate($mskin);

$pageadd_array = array(
	"PAGEADD_PAGETITLE" => $L['page_addtitle'],
	"PAGEADD_SUBTITLE" => $L['page_addsubtitle'],
	"PAGEADD_ADMINEMAIL" => "mailto:".$cfg['adminemail'],
	"PAGEADD_FORM_SEND" => cot_url('page', 'm=add&a=add'),
	"PAGEADD_FORM_CAT" => cot_selectbox_categories($rpage['page_cat'], 'rpagecat'),
	"PAGEADD_FORM_CAT_SHORT" => cot_selectbox_categories($rpage['page_cat'], 'rpagecat', $c),
	"PAGEADD_FORM_KEY" => cot_inputbox('text', 'rpagekey', $rpage['page_key'], array('size' => '16', 'maxlength' => '16')),
	"PAGEADD_FORM_ALIAS" => cot_inputbox('text', 'rpagealias', $rpage['page_alias'], array('size' => '32', 'maxlength' => '255')),
	"PAGEADD_FORM_TITLE" => cot_inputbox('text', 'rpagetitle', $rpage['page_title'], array('size' => '64', 'maxlength' => '255')),
	"PAGEADD_FORM_DESC" => cot_inputbox('text', 'rpagedesc', $rpage['page_desc'], array('size' => '64', 'maxlength' => '255')),
	"PAGEADD_FORM_AUTHOR" => cot_inputbox('text', 'rpageauthor', $rpage['page_author'], array('size' => '16', 'maxlength' => '24')),
	"PAGEADD_FORM_OWNER" => cot_build_user($usr['id'], htmlspecialchars($usr['name'])),
	"PAGEADD_FORM_OWNERID" => $usr['id'],
	"PAGEADD_FORM_BEGIN" => cot_selectbox_date($sys['now_offset'], 'long', 'rpagebegin'),
	"PAGEADD_FORM_EXPIRE" => cot_selectbox_date($sys['now_offset'] + 31536000, 'long', 'rpageexpire'),
	"PAGEADD_FORM_FILE" => cot_selectbox($rpage['page_file'], 'rpagefile', range(0, 2), array($L['No'], $L['Yes'], $L['Members_only']), false),
	"PAGEADD_FORM_URL" => cot_inputbox('text', 'rpageurl', $rpage['page_url'], array('size' => '56', 'maxlength' => '255')),
	"PAGEADD_FORM_SIZE" => cot_inputbox('text', 'rpagesize', $rpage['page_size'], array('size' => '56', 'maxlength' => '255')),
	"PAGEADD_FORM_TEXT" => cot_textarea('rpagetext', $rpage['page_text'], 24, 120, '', 'input_textarea_editor')
);

$t->assign($pageadd_array);

// Extra fields
foreach($cot_extrafields['pages'] as $i => $row)
{
	$uname = strtoupper($row['field_name']);
	$t->assign('PAGEADD_FORM_'.$uname, cot_build_extrafields('rpage'.$row['field_name'], $row, $rpage[$row['field_name']]));
	$t->assign('PAGEADD_FORM_'.$uname.'_TITLE', isset($L['page_'.$row['field_name'].'_title']) ?  $L['page_'.$row['field_name'].'_title'] : $row['field_description']);
}

// Error and message handling
cot_display_messages($t);

/* === Hook === */
foreach (cot_getextplugins('page.add.tags') as $pl)
{
	include $pl;
}
/* ===== */

if ($usr['isadmin'])
{
	if ($cfg['page']['autovalidate']) $usr_can_publish = TRUE;
	$t->parse('MAIN.ADMIN');
}

$t->parse("MAIN");
$t->out("MAIN");

require_once $cfg['system_dir'].'/footer.php';

?>