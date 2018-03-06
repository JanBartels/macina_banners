<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

return array(
	'ctrl' => array (
		'title' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_categories',
		'label' => 'description',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY description',
		'iconfile' => 'EXT:macina_banners/ext_icon.gif',
		'thumbnail' => 'icon',
	),
	'interface' => array (
		'showRecordFieldList' => 'description'
	),
	'columns' => array (
		'description' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_categories.description',
			'config' => array (
				'type' => 'input',
				'size' => '30',
				'eval' => 'trim',
			)
		),
		'icon' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_categories.icon',
			'config' => array (
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
				'max_size' => 500,
				'uploadfolder' => 'uploads/tx_macinabanners',
				'show_thumbs' => 1,
				'size' => 1,
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'description;;;;1-1-1, icon')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);
