<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToInsertRecords('tx_macinabanners_banners');

$macinaCfg = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['macina_banners']);
$renderType = 'selectMultipleSideBySide';
if ($macinaCfg['renderMode'] == 'singlebox' || $macinaCfg['renderMode'] == 'checkbox') {
	$renderType = $macinaCfg['renderMode'];
}
unset ($macinaCfg);

return array(
	'ctrl' => array (
		'title' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners',
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
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('macina_banners').'Resources/Public/Images/icon_tx_macinabanners_banners.gif',
	),
	'interface' => Array (
		'showRecordFieldList' => 'hidden,starttime,endtime,fe_group,sys_language_uid,t3ver_label,l18n_parent,customer,bannertype,image,maxw,alttext,url,swf,flash_width,flash_height,html,placement,border_top,border_right,border_bottom,border_left,pages,recursiv,excludepages,impressions,clicks,parameters'
	),
	'columns' => Array (
		'hidden' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => Array (
				'type' => 'check',
				'default' => '0'
			)
		),
		'starttime' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
			'config' => Array (
				'type' => 'input',
				'size' => '8',
				'max' => '20',
				'eval' => 'date',
				'default' => '0',
				'checkbox' => '0'
			)
		),
		'endtime' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
			'config' => Array (
				'type' => 'input',
				'size' => '8',
				'max' => '20',
				'eval' => 'date',
				'checkbox' => '0',
				'default' => '0',
				'range' => Array (
					'upper' => mktime(0,0,0,12,31,2020),
					'lower' => mktime(0,0,0,date('m')-1,date('d'),date('Y'))
				)
			)
		),
		'fe_group' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.fe_group',
			'config' => Array (
				'type' => 'select',
				'items' => Array (
					Array('', 0),
					Array('LLL:EXT:lang/locallang_general.xlf:LGL.hide_at_login', -1),
					Array('LLL:EXT:lang/locallang_general.xlf:LGL.any_login', -2),
					Array('LLL:EXT:lang/locallang_general.xlf:LGL.usergroups', '--div--')
				),
				'foreign_table' => 'fe_groups'
			)
		),
		'customer' => Array (
			'exclude' => 0,
			'label' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.customer',
			'config' => Array (
				'type' => 'input',
				'size' => '30',
				'eval' => 'required',
			)
		),
		'bannertype' => Array (
			'exclude' => 0,
			'label' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.bannertype',
			'config' => Array (
				'type' => 'select',
				'items' => Array (
					Array('LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.bannertype.I.0', '0'),
					Array('LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.bannertype.I.1', '1'),
					Array('LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.bannertype.I.2', '2'),
				),
				'size' => 1,
				'maxitems' => 1,
			)
		),
		't3ver_label' => Array (
			'exclude' => 0,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
			'config' => Array (
				'type' => 'input',
				'size' => 30,
				'max' => 30,
			)
		),
		'sys_language_uid' => Array (
			'exclude' => 0,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => Array(
					Array('LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages',-1),
					Array('LLL:EXT:lang/locallang_general.xlf:LGL.default_value',0)
				)
			)
		),
		'l18n_parent' => Array (
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 0,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
			'config' => Array (
				'type' => 'select',
				'items' => Array (
					Array('', 0),
				),
				'foreign_table' => 'tx_macinabanners_banners',
				'foreign_table_where' => 'AND tx_macinabanners_banners.pid=###CURRENT_PID### AND  tx_macinabanners_banners.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => Array(
			'config'=>array('type'=>'passthrough')
		),
		'image' => Array (
			'exclude' => 0,
			'label' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.image',
			'config' => Array (
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
				'max_size' => 1000,
				'uploadfolder' => 'uploads/tx_macinabanners',
				'show_thumbs' => 1,
				'size' => 1,
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
		'maxw' => Array (
			'exclude' => 0,
			'label' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.maxw',
			'config' => Array (
				'type' => 'input',
				'size' => '5',
				'eval' => 'int,nospace',
			)
		),
		'alttext' => Array (
			'exclude' => 0,
			'label' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.alttext',
			'config' => Array (
				'type' => 'input',
				'size' => '30',
			)
		),
		'url' => Array (
			'exclude' => 0,
			'label' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.url',
			'config' => Array (
				'type' => 'input',
				'size' => '15',
				'max' => '255',
				'checkbox' => '',
				'eval' => 'trim',
				'softref' => 'typolink',
				'wizards' => Array(
					'link' => Array(
						'type' => 'popup',
						'title' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header_link_formlabel',
						'icon' => 'link_popup.gif',
						'module' => array(
							'name' => 'wizard_link'
						 ) ,
						'JSopenParams' => 'height=300,width=500,status=0,menubar=0,scrollbars=1',
						'params' => [
						   'blindLinkOptions' => 'folder,mail',
						   'blindLinkFields' => 'class, target'
						],
					)
				)
			)
		),
		'swf' => Array (
			'exclude' => 0,
			'label' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.swf',
			'config' => Array (
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => '',
				'disallowed' => 'php,php3',
				'max_size' => 1000,
				'uploadfolder' => 'uploads/tx_macinabanners',
				'size' => 1,
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
		'flash_width' => Array (
			'exclude' => 0,
			'label' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.flash_width',
			'config' => Array (
				'type' => 'input',
				'size' => '5',
				'eval' => 'required,int,nospace',
			)
		),
		'flash_height' => Array (
			'exclude' => 0,
			'label' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.flash_height',
			'config' => Array (
				'type' => 'input',
				'size' => '5',
				'eval' => 'required,int,nospace',
			)
		),
		//medialights: new type html
		'html' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.html',
			'config' => Array (
				'type' => 'text',
				'cols' => '30',
				'rows' => '5',
			)
		),
		'placement' => Array (
			'exclude' => 0,
			'label' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.placement',
			'config' => Array (
				'type' => 'select',
				'itemsProcFunc' => 'JBartels\\MacinaBanners\\BackendHelper\\Placement->main',
				'renderType' => $renderType,
				'size' => 5,
				'maxitems' => 50,
			)
		),
		'border_top' => Array (
			'exclude' => 0,
			'label' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.border_top',
			'config' => Array (
				'type' => 'input',
				'size' => '5',
				'max' => '4',
				'range' => Array ('lower'=>0,'upper'=>1000),
				'eval' => 'int,nospace',
			)
		),
		'border_right' => Array (
			'exclude' => 0,
			'label' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.border_right',
			'config' => Array (
				'type' => 'input',
				'size' => '5',
				'max' => '4',
				'range' => Array ('lower'=>0,'upper'=>1000),
				'eval' => 'int,nospace',
			)
		),
		'border_bottom' => Array (
			'exclude' => 0,
			'label' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.border_bottom',
			'config' => Array (
				'type' => 'input',
				'size' => '5',
				'max' => '4',
				'range' => Array ('lower'=>0,'upper'=>1000),
				'eval' => 'int,nospace',
			)
		),
		'border_left' => Array (
			'exclude' => 0,
			'label' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.border_left',
			'config' => Array (
				'type' => 'input',
				'size' => '5',
				'max' => '4',
				'range' => Array ('lower'=>0,'upper'=>1000),
				'eval' => 'int,nospace',
			)
		),
		'pages' => Array (
			'exclude' => 0,
			'label' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.pages',
			'config' => Array (
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'pages',
				'size' => 3,
				'minitems' => 0,
				'maxitems' => 100,
			)
		),
		'recursiv' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.recursiv',
			'config' => Array (
				'type' => 'check',
				'default' => '0'
			)
		),
		'excludepages' => Array (
			'exclude' => 0,
			'label' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.excludepages',
			'config' => Array (
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'pages',
				'size' => 3,
				'minitems' => 0,
				'maxitems' => 100,
			)
		),
		'impressions' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.impressions',
			'config' => Array (
				'type' => 'none',
			)
		),
		'clicks' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.clicks',
			'config' => Array (
				'type' => 'none',
			)
		),
		'parameters' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.parameters',
			'config' => Array (
				'type' => 'text',
				'cols' => '30',
				'rows' => '5',
			)
		),
	),
	'types' => Array (
		'0' => Array(
				'showitem' => '--div--;LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.general,customer,l18n_parent,bannertype,sys_language_uid,parameters,--div--;LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.bannerimage,image;;3;;1-1-1, alttext,url,--div--;LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.view, placement;;;;1-1-1,pages, recursiv, excludepages,--div--;LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.visibility,hidden;;1;;1-1-1,--div--;LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.statistics,impressions, clicks'
		),
		'1' => Array(
				'showitem' => '--div--;LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.general,customer,l18n_parent,bannertype,sys_language_uid,parameters,--div--;LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.flashfilm,swf;;;;1-1-1, url, flash_width, flash_height;;2,--div--;LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.view, placement;;;;1-1-1,pages, recursiv, excludepages,--div--;LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.visibility,hidden;;1;;1-1-1,--div--;LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.statistics,impressions, clicks'
		),
		'2' => Array(
				'showitem' => '--div--;LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.general,customer,l18n_parent,bannertype,sys_language_uid,parameters,--div--;LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.html,html,--div--;LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.view, placement;;;;1-1-1,pages, recursiv, excludepages,--div--;LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.visibility,hidden;;1;;1-1-1,--div--;LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.statistics,impressions, clicks'
		),
	),
	// '1' => Array('showitem' => 'bannertype, sys_language_uid, l18n_parent, swf;;;;1-1-1, flash_width, flash_height;;2, placement;;;;1-1-1, pages, recursiv, excludepages, customer;;;;1-1-1, impressions, hidden;;1;;1-1-1')
	// '0' => Array('showitem' => 'bannertype, sys_language_uid, l18n_parent, image;;3;;1-1-1, alttext, url, placement;;;;1-1-1, pages, recursiv, excludepages, customer;;;;1-1-1,impressions, clicks, hidden;;1;;1-1-1'),;
	'palettes' => Array (
		'1' => Array('showitem' => 'starttime, endtime, fe_group'),
		'2' => Array('showitem' => 'border_left, border_top, border_right, border_bottom'),
		'3' => Array('showitem' => 'maxw, border_left, border_top, border_right, border_bottom'),
		'4' => Array('showitem' => ''),
		'5' => Array('showitem' => 'impressions')
	)
);

?>