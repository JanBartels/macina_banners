<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2006 Markus Friedrich (markus.friedrich@media-lights.de)
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
/**
 * Class/Function which manipulates the item-array for table/field tt_content_tx_macinabanners_placement.
 *
 * @author    Markus Friedrich <markus.friedrich@media-lights.de>
 */


class tx_macinabanners_tt_content_tx_macinabanners_placement {
	
	function main(&$params,&$pObj)    {
		global $TYPO3_DB, $TCA;
		
		//get upload folder
		t3lib_div::loadTCA('tx_macinabanners_categories');
		$uploadFolder = $TCA['tx_macinabanners_categories']['columns']['icon']['config']['uploadfolder'];
		
		//get items from database and add them to the list
		$RS = $TYPO3_DB->exec_SELECTquery('*', 'tx_macinabanners_categories', '');
		while ($row = $TYPO3_DB->sql_fetch_assoc($RS)) {
			//check if there is an icon
			if (!empty($row['icon']) && file_exists(PATH_site.$uploadFolder.'/'.$row['icon'])) {
				$icon = '../' . $uploadFolder . '/' . $row['icon'];
			} else {
				$icon = '';
			}
			
			$params['items'][]=Array($row['description'], 'tx_macinabanners_categories:'.$row['uid'], $icon);
		}
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/macina_banners/class.tx_macinabanners_tt_content_tx_macinabanners_placement.php'])    {
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/macina_banners/class.tx_macinabanners_tt_content_tx_macinabanners_placement.php']);
}

?>