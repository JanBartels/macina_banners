<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

/* Set up the tt_content fields for the frontend plugins */
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['macina_banners_pi1']='layout,select_key';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['macina_banners_pi1']='tx_macinabanners_placement;;;;1-1-1, tx_macinabanners_mode';

/* Add the plugins */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(array('LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tt_content.list_type_pi1', 'macina_banners_pi1'),'list_type', 'macina_banners');

/* Add the flexforms to the TCA */
//\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('macina_banners_pi1', 'FILE:EXT:macina_banners/Configuration/FlexForms/Pi1.xml');

//medialights: configure the renderMode placement
$macinaCfg = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['macina_banners']);
$renderType = 'selectMultipleSideBySide';
if ($macinaCfg['renderMode'] == 'singlebox' || $macinaCfg['renderMode'] == 'checkbox') {
	$renderType = $macinaCfg['renderMode'];
}
unset ($macinaCfg);

$tempColumns = array(
	'tx_macinabanners_placement' => array (
		'exclude' => 0,
		'label' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tt_content.tx_macinabanners_placement',
		'config' => array (
			'type' => 'select',
			'itemsProcFunc' => 'JBartels\\MacinaBanners\\BackendHelper\\Placement->main',
			'renderType' => $renderType,
			'size' => 5,
			'maxitems' => 50,
		)
	),
	'tx_macinabanners_mode' => array (
		'exclude' => 0,
		'label' => 'LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tt_content.tx_macinabanners_mode',
		'config' => array (
			'type' => 'select',
			'renderType' => 'selectSingle',
			'items' => array (
				array('LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tt_content.tx_macinabanners_mode.I.0', 'all', 'EXT:macina_banners/Resources/Public/Images/selicon_tt_content_tx_macinabanners_mode_0.gif'),
				array('LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tt_content.tx_macinabanners_mode.I.1', 'random', 'EXT:macina_banners/Resources/Public/Images/selicon_tt_content_tx_macinabanners_mode_1.gif'),
				//medialights: add 'all banners randomized' mode
				array('LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tt_content.tx_macinabanners_mode.I.2', 'random_all', 'EXT:macina_banners/Resources/Public/Images/selicon_tt_content_tx_macinabanners_mode_2.gif'),
			),
			'size' => 1,
			'maxitems' => 1,
		)
	),
);

unset( $renderType );
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content',$tempColumns);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tt_content', 'tx_macinabanners_placement,tx_macinabanners_mode' );
