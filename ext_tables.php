<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');
$tempColumns = array (
	'tx_macinabanners_placement' => array (
		'exclude' => 0,
		'label' => 'LLL:EXT:macina_banners/locallang_db.php:tt_content.tx_macinabanners_placement',
		'config' => array (
			'type' => 'select',
			/* medialights: default categories are only added if configured in the EM
			'items' => array (
				array('LLL:EXT:macina_banners/locallang_db.php:tt_content.tx_macinabanners_placement.I.0', 'top', t3lib_extMgm::extRelPath('macina_banners').'selicon_tt_content_tx_macinabanners_placement_0.gif'),
				array('LLL:EXT:macina_banners/locallang_db.php:tt_content.tx_macinabanners_placement.I.1', 'right', t3lib_extMgm::extRelPath('macina_banners').'selicon_tt_content_tx_macinabanners_placement_1.gif'),
				array('LLL:EXT:macina_banners/locallang_db.php:tt_content.tx_macinabanners_placement.I.2', 'bottom', t3lib_extMgm::extRelPath('macina_banners').'selicon_tt_content_tx_macinabanners_placement_2.gif'),
				array('LLL:EXT:macina_banners/locallang_db.php:tt_content.tx_macinabanners_placement.I.3', 'left', t3lib_extMgm::extRelPath('macina_banners').'selicon_tt_content_tx_macinabanners_placement_3.gif'),
			),
			*/
			'itemsProcFunc' => 'tx_macinabanners_tt_content_tx_macinabanners_placement->main',
			//medialights: size and maxitems increased from 1
			'size' => 5,
			'maxitems' => 50,

			//medialights: activate icons in select boxes
			'iconsInOptionTags' => 1
		)
	),
	'tx_macinabanners_mode' => array (
		'exclude' => 0,
		'label' => 'LLL:EXT:macina_banners/locallang_db.php:tt_content.tx_macinabanners_mode',
		'config' => array (
			'type' => 'select',
			'items' => array (
				array('LLL:EXT:macina_banners/locallang_db.php:tt_content.tx_macinabanners_mode.I.0', 'all', t3lib_extMgm::extRelPath('macina_banners').'selicon_tt_content_tx_macinabanners_mode_0.gif'),
				array('LLL:EXT:macina_banners/locallang_db.php:tt_content.tx_macinabanners_mode.I.1', 'random', t3lib_extMgm::extRelPath('macina_banners').'selicon_tt_content_tx_macinabanners_mode_1.gif'),
				//medialights: add 'all banners randomized' mode
				array('LLL:EXT:macina_banners/locallang_db.php:tt_content.tx_macinabanners_mode.I.2', 'random_all', t3lib_extMgm::extRelPath('macina_banners').'selicon_tt_content_tx_macinabanners_mode_2.gif'),
			),
			'size' => 1,
			'maxitems' => 1,
		)
	),
);

//medialights: include itemProcFunc
if (TYPO3_MODE=='BE') {
	include_once(t3lib_extMgm::extPath('macina_banners').'class.tx_macinabanners_tt_content_tx_macinabanners_placement.php');
}

//medialights: include default categories if demanded
$macinaCfg = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['macina_banners']);
if ($macinaCfg['activateDefaultCategories']) {
	$tempColumns['tx_macinabanners_placement']['config']['items'] = array (
		array('LLL:EXT:macina_banners/locallang_db.php:tx_macinabanners_banners.placement.I.0', 'top', t3lib_extMgm::extRelPath('macina_banners').'selicon_tx_macinabanners_banners_placement_0.gif'),
		array('LLL:EXT:macina_banners/locallang_db.php:tx_macinabanners_banners.placement.I.1', 'right', t3lib_extMgm::extRelPath('macina_banners').'selicon_tx_macinabanners_banners_placement_1.gif'),
		array('LLL:EXT:macina_banners/locallang_db.php:tx_macinabanners_banners.placement.I.2', 'bottom', t3lib_extMgm::extRelPath('macina_banners').'selicon_tx_macinabanners_banners_placement_2.gif'),
		array('LLL:EXT:macina_banners/locallang_db.php:tx_macinabanners_banners.placement.I.3', 'left', t3lib_extMgm::extRelPath('macina_banners').'selicon_tx_macinabanners_banners_placement_3.gif'),
	);
}

//medialights: configure the renderMode placement
if ($macinaCfg['renderMode'] == 'singlebox' || $macinaCfg['renderMode'] == 'checkbox') {
	$tempColumns['tx_macinabanners_placement']['config']['renderMode'] = $macinaCfg['renderMode'];
}
unset ($macinaCfg);

t3lib_div::loadTCA('tt_content');
t3lib_extMgm::addTCAcolumns('tt_content',$tempColumns,1);
t3lib_extMgm::allowTableOnStandardPages('tx_macinabanners_banners');
t3lib_extMgm::addToInsertRecords('tx_macinabanners_banners');
$TCA['tx_macinabanners_banners'] = array (
	'ctrl' => array (
		'title' => 'LLL:EXT:macina_banners/locallang_db.php:tx_macinabanners_banners',
		'label' => 'customer',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'type' => 'bannertype',
		'sortby' => 'sorting',
		'delete' => 'deleted',
		'thumbnail' => 'image',
		'versioning'=>1,
		'versioning_followPages'=>1,
		'transOrigPointerField'=>'l18n_parent',
		'transOrigDiffSourceField'=>'l18n_diffsource',
		'languageField'=>'sys_language_uid',
		'dividers2tabs'=>1,
		'enablecolumns' => array (
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
			'fe_group' => 'fe_group',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_macinabanners_banners.gif',
	),
	'feInterface' => array (
		//medialights: add html
		'fe_admin_fieldList' => 'hidden, starttime, endtime, fe_group, sys_language_uid, t3ver_label, l18n_parent, customer, bannertype, image, maxw, alttext, url, swf, flash_width, flash_height, html, placement, border_top, border_right, border_bottom, border_left, pages, impressions, clicks, parameters',
	)
);


// medialights: initalize 'context sensitive help' (csh)
t3lib_extMgm::addLLrefForTCAdescr('tx_macinabanners_banners','EXT:macina_banners/locallang_csh_banners.php');

t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY.'_pi1']='tx_macinabanners_placement;;;;1-1-1, tx_macinabanners_mode';


//medialights: add definition for 'tx_macinabanners_categories'
$TCA['tx_macinabanners_categories'] = array (
	'ctrl' => array (
		'title' => 'LLL:EXT:macina_banners/locallang_db.php:tx_macinabanners_categories',
		'label' => 'description',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY description',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY).'ext_icon.gif',
		'thumbnail' => 'icon',
	),
	'feInterface' => array (
		'fe_admin_fieldList' => 'description, icon',
	)
);

t3lib_extMgm::addPlugin(array('LLL:EXT:macina_banners/locallang_db.php:tt_content.list_type_pi1', $_EXTKEY.'_pi1'),'list_type');
// visionate removed static incluses
#t3lib_extMgm::addStaticFile($_EXTKEY,'pi1/static/','Bannermodule');

if (TYPO3_MODE=='BE') {
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_macinabanners_pi1_wizicon'] = t3lib_extMgm::extPath($_EXTKEY).'pi1/class.tx_macinabanners_pi1_wizicon.php';
}
?>