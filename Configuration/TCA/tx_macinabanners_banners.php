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
		'iconfile' => 'EXT:macina_banners/Resources/Public/Images/icon_tx_macinabanners_banners.gif',
	),
	'interface' => array (
		'showRecordFieldList' => 'hidden,starttime,endtime,fe_group,sys_language_uid,t3ver_label,l18n_parent,customer,bannertype,image,maxw,alttext,url,swf,flash_width,flash_height,html,placement,border_top,border_right,border_bottom,border_left,pages,recursiv,excludepages,impressions,clicks,parameters'
	),
	'columns' => array (
		'hidden' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.disable',
			'config' => array (
				'type' => 'check',
				'default' => '0'
			)
		),
		'starttime' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
			'config' => array (
				'type' => 'input',
				'size' => '8',
				'max' => '20',
				'eval' => 'date',
				'default' => '0',
				'checkbox' => '0'
			)
		),
		'endtime' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
			'config' => array (
				'type' => 'input',
				'size' => '8',
				'max' => '20',
				'eval' => 'date',
				'checkbox' => '0',
				'default' => '0',
			)
		),
		'fe_group' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.fe_group',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectMultipleSideBySide',
				'size' => 7,
				'maxitems' => 20,
				'items' => array(
					array(
						'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.hide_at_login',
						-1
					),
					array(
						'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.any_login',
						-2
					),
					array(
						'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.usergroups',
						'--div--'
					)
				),
				'exclusiveKeys' => '-1,-2',
				'foreign_table' => 'fe_groups',
				'foreign_table_where' => 'ORDER BY fe_groups.title',
				'enableMultiSelectFilterTextfield' => true
			)
		),
		'customer' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.customer',
			'config' => array (
				'type' => 'input',
				'size' => '30',
				'eval' => 'required',
			)
		),
		'bannertype' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.bannertype',
			'config' => array (
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => array (
					array('LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.bannertype.I.0', '0'),
					array('LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.bannertype.I.1', '1'),
					array('LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.bannertype.I.2', '2'),
				),
				'size' => 1,
				'maxitems' => 1,
			)
		),
		't3ver_label' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.versionLabel',
			'config' => array (
				'type' => 'input',
				'size' => 30,
				'max' => 30,
			)
		),
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.language',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'special' => 'languages',
				'items' => array(
					array('LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages', -1, 'flags-multiple'),
					array('LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.default_value', 0)
				)
			),
		),
		'l18n_parent' => array (
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 0,
			'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
			'config' => array (
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => array (
					array('', 0),
				),
				'foreign_table' => 'tx_macinabanners_banners',
				'foreign_table_where' => 'AND tx_macinabanners_banners.pid=###CURRENT_PID### AND  tx_macinabanners_banners.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => array(
			'config'=>array('type'=>'passthrough')
		),
		'image' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.image',
			'config' => array (
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
		'maxw' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.maxw',
			'config' => array (
				'type' => 'input',
				'size' => '5',
				'eval' => 'int,nospace',
			)
		),
		'alttext' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.alttext',
			'config' => array (
				'type' => 'input',
				'size' => '30',
			)
		),
		'url' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.url',
			'config' => array (
				'type' => 'input',
				'size' => '15',
				'max' => '255',
				'checkbox' => '',
				'eval' => 'trim',
				'softref' => 'typolink',
				'wizards' => array(
					'link' => array(
						'type' => 'popup',
						'title' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header_link_formlabel',
						'icon' => 'actions-wizard-link',
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
		'swf' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.swf',
			'config' => array (
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
		'flash_width' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.flash_width',
			'config' => array (
				'type' => 'input',
				'size' => '5',
				'eval' => 'required,int,nospace',
			)
		),
		'flash_height' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.flash_height',
			'config' => array (
				'type' => 'input',
				'size' => '5',
				'eval' => 'required,int,nospace',
			)
		),
		//medialights: new type html
		'html' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.html',
			'config' => array (
				'type' => 'text',
				'cols' => '30',
				'rows' => '5',
			)
		),
		'placement' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.placement',
			'config' => array (
				'type' => 'select',
				'itemsProcFunc' => 'JBartels\\MacinaBanners\\BackendHelper\\Placement->main',
				'renderType' => $renderType,
				'size' => 5,
				'maxitems' => 50,
			)
		),
		'border_top' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.border_top',
			'config' => array (
				'type' => 'input',
				'size' => '5',
				'max' => '4',
				'range' => array ('lower'=>0,'upper'=>1000),
				'eval' => 'int,nospace',
			)
		),
		'border_right' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.border_right',
			'config' => array (
				'type' => 'input',
				'size' => '5',
				'max' => '4',
				'range' => array ('lower'=>0,'upper'=>1000),
				'eval' => 'int,nospace',
			)
		),
		'border_bottom' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.border_bottom',
			'config' => array (
				'type' => 'input',
				'size' => '5',
				'max' => '4',
				'range' => array ('lower'=>0,'upper'=>1000),
				'eval' => 'int,nospace',
			)
		),
		'border_left' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.border_left',
			'config' => array (
				'type' => 'input',
				'size' => '5',
				'max' => '4',
				'range' => array ('lower'=>0,'upper'=>1000),
				'eval' => 'int,nospace',
			)
		),
		'pages' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.pages',
			'config' => array (
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'pages',
				'size' => 3,
				'minitems' => 0,
				'maxitems' => 100,
			)
		),
		'recursiv' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.recursiv',
			'config' => array (
				'type' => 'check',
				'default' => '0'
			)
		),
		'excludepages' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.excludepages',
			'config' => array (
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'pages',
				'size' => 3,
				'minitems' => 0,
				'maxitems' => 100,
			)
		),
		'impressions' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.impressions',
			'config' => array (
				'type' => 'none',
			)
		),
		'clicks' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.clicks',
			'config' => array (
				'type' => 'none',
			)
		),
		'parameters' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.parameters',
			'config' => array (
				'type' => 'text',
				'cols' => '30',
				'rows' => '5',
			)
		),
	),
	'types' => array (
		'0' => array(
				'showitem' => '--div--;LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.general,customer,l18n_parent,bannertype,sys_language_uid,parameters,--div--;LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.bannerimage,image;;3;;1-1-1, alttext,url,--div--;LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.view, placement;;;;1-1-1,pages, recursiv, excludepages,--div--;LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.visibility,hidden;;1;;1-1-1,--div--;LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.statistics,impressions, clicks'
		),
		'1' => array(
				'showitem' => '--div--;LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.general,customer,l18n_parent,bannertype,sys_language_uid,parameters,--div--;LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.flashfilm,swf;;;;1-1-1, url, flash_width, flash_height;;2,--div--;LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.view, placement;;;;1-1-1,pages, recursiv, excludepages,--div--;LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.visibility,hidden;;1;;1-1-1,--div--;LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.statistics,impressions, clicks'
		),
		'2' => array(
				'showitem' => '--div--;LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.general,customer,l18n_parent,bannertype,sys_language_uid,parameters,--div--;LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.html,html,--div--;LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.view, placement;;;;1-1-1,pages, recursiv, excludepages,--div--;LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.visibility,hidden;;1;;1-1-1,--div--;LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.statistics,impressions, clicks'
		),
	),
	// '1' => array('showitem' => 'bannertype, sys_language_uid, l18n_parent, swf;;;;1-1-1, flash_width, flash_height;;2, placement;;;;1-1-1, pages, recursiv, excludepages, customer;;;;1-1-1, impressions, hidden;;1;;1-1-1')
	// '0' => array('showitem' => 'bannertype, sys_language_uid, l18n_parent, image;;3;;1-1-1, alttext, url, placement;;;;1-1-1, pages, recursiv, excludepages, customer;;;;1-1-1,impressions, clicks, hidden;;1;;1-1-1'),;
	'palettes' => array (
		'1' => array('showitem' => 'starttime, endtime, --linebreak--, fe_group'),
		'2' => array('showitem' => 'border_left, border_top, border_right, border_bottom'),
		'3' => array('showitem' => 'maxw, border_left, border_top, border_right, border_bottom'),
		'4' => array('showitem' => ''),
		'5' => array('showitem' => 'impressions')
	)
);
