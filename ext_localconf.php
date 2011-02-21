<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

t3lib_extMgm::addUserTSConfig('options.saveDocNew.tx_macinabanners_banners=1');

## Extending TypoScript from static template uid=43 to set up userdefined tag:
t3lib_extMgm::addTypoScript($_EXTKEY,'editorcfg','
	tt_content.CSS_editor.ch.tx_macinabanners_pi1 = < plugin.tx_macinabanners_pi1.CSS_editor
',43);

//medialights: deactivated caching 
//t3lib_extMgm::addPItoST43($_EXTKEY,'pi1/class.tx_macinabanners_pi1.php','_pi1','list_type',0);
t3lib_extMgm::addPItoST43($_EXTKEY,'pi1/class.tx_macinabanners_pi1.php','_pi1','list_type',1);

t3lib_extMgm::addTypoScript($_EXTKEY,'setup','
	tt_content.shortcut.20.0.conf.tx_macinabanners_banners = < plugin.'.t3lib_extMgm::getCN($_EXTKEY).'_pi1
	tt_content.shortcut.20.0.conf.tx_macinabanners_banners.CMD = singleView
',43);

// Support for banners in the Page module
$TYPO3_CONF_VARS['EXTCONF']['cms']['db_layout']['addTables']['tx_macinabanners_banners'][0] = array(
	'fList' => 'customer;image;url;placement,bannertype',
	'icon' => TRUE
);

?>