<?php

/***************************************************************
*  Copyright notice
*
*  (c) 2006 Markus Friedrich (markus.friedrich@media-lights.de)
*  (c) 2017 Jan Bartels
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

namespace JBartels\MacinaBanners\BackendHelper;

/**
 * Class/Function which manipulates the item-array for table/field tt_content_tx_macinabanners_placement.
 *
 * @author    Markus Friedrich <markus.friedrich@media-lights.de>
 */
class Placement {

	function main(&$params,&$pObj) {

		//medialights: include default categories if demanded
		$macinaCfg = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['macina_banners']);
		if ($macinaCfg['activateDefaultCategories']) {
			$params['items'][] = array('LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.placement.I.0', 'top', 'EXT:macina_banners/Resources/Public/Images/selicon_tx_macinabanners_banners_placement_0.gif');
			$params['items'][] = array('LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.placement.I.1', 'right', 'EXT:macina_banners/Resources/Public/Images/selicon_tx_macinabanners_banners_placement_1.gif');
			$params['items'][] = array('LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.placement.I.2', 'bottom', 'EXT:macina_banners/Resources/Public/Images/selicon_tx_macinabanners_banners_placement_2.gif');
			$params['items'][] = array('LLL:EXT:macina_banners/Resources/Private/Languages/locallang_db.xlf:tx_macinabanners_banners.placement.I.3', 'left', 'EXT:macina_banners/Resources/Public/Images/selicon_tx_macinabanners_banners_placement_3.gif');
		} else {

			//get upload folder
			$uploadFolder = $GLOBALS['TCA']['tx_macinabanners_categories']['columns']['icon']['config']['uploadfolder'];

			//get items from database and add them to the list
			$rows = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*', 'tx_macinabanners_categories', '');
			while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($rows)) {
				//check if there is an icon
				if (!empty($row['icon']) && file_exists(PATH_site.$uploadFolder.'/'.$row['icon'])) {
					$icon = '../' . $uploadFolder . '/' . $row['icon'];
				} else {
					$icon = '';
				}

				$params['items'][] = array($row['description'], 'tx_macinabanners_categories:'.$row['uid'], $icon);
			}
		}
	}
}
