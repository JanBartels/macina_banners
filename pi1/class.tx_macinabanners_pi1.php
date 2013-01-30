<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2003 Wolfgang Becker (wb@macina.com)
 *  All rights reserved
 *
 *  This script is part of the Typo3 project. The Typo3 project is
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
 * Plugin 'Bannermodule' for the 'macina_banners' extension.
 *
 * @author Wolfgang Becker <wb@macina.com>
 */
require_once(PATH_tslib . 'class.tslib_pibase.php');

/**
 * Class for creating a banner extension
 *
 * @author	Wolfgang <wb@macina.com>
 * @package TYPO3
 * @subpackage tx_macinabanners
 */
class tx_macinabanners_pi1 extends tslib_pibase {

	var $prefixId = 'tx_macinabanners_pi1'; // Same as class name
	var $scriptRelPath = 'pi1/class.tx_macinabanners_pi1.php'; // Path to this script relative to the extension dir.
	var $extKey = 'macina_banners'; // The extension key.
	var $siteRelPath;

	/**
	 * main function invoked by index.php
	 *
	 * @param	string		$content: main variable carriing the content
	 * @param	array		$conf: config array from typoscript
	 * @return	string		html content
	 */
	function main($content, $conf) {
		$this->pi_USER_INT_obj = 1; // Any link to yourself won't expect to be cached (no cHash and no_cache=1)

		// forwarder
		if ($this->piVars['banneruid']) {
			$this->conf = $conf;
			$this->pi_setPiVarDefaults();
			$this->pi_loadLL();

			// get link details
			$record = $this->pi_getRecord('tx_macinabanners_banners', $this->piVars['banneruid'], $checkPage=0);

			if ($record != FALSE) {
				// update clicks
				$GLOBALS['TYPO3_DB']->exec_UPDATEquery(
					'tx_macinabanners_banners',
					'uid='.$GLOBALS['TYPO3_DB']->fullQuoteStr($record['uid'], 'tx_macinabanners_banners'),
					array('clicks' => ++$record['clicks'])
				);

				// get URL
				unset($this->piVars['banneruid']);
				$url = t3lib_div::locationHeaderUrl($this->cObj->getTypoLink_URL($record['url']));
				header('Location: '.$url);
				exit;
			}
		}

		switch ((string)$conf['CMD']) {
			case 'singleView':
				list($t) = explode(':', $this->cObj->currentRecord);
				$this->internal['currentTable'] = $t;
				$this->internal['currentRow'] = $this->cObj->data;
				$content = $this->singleView($content, $conf);
				return $content;
				break;
			default:
				if (strstr($this->cObj->currentRecord, 'tt_content')) {
					$conf['pidList'] = $this->cObj->data['pages'];
					$conf['recursive'] = $this->cObj->data['recursive'];
					$conf['placement'] = $this->cObj->data['tx_macinabanners_placement'];
					$conf['mode'] = $this->cObj->data['tx_macinabanners_mode'];
				}
				/* medialights: didn't work with deactivated caching in 'ext_localconf.php -> addPItoST43'*/
				//PRS+ 12.08.2005
				if ($conf['mode'] == 'random' || $conf['mode'] == 'random_all' || $conf['enableParameterRestriction'] == 1) {
					$substKey = 'INT_SCRIPT.'.$GLOBALS['TSFE']->uniqueHash();
					$link='<!--'.$substKey.'-->';
					$conf['userFunc'] = 'tx_macinabanners_pi1->listView';
					$GLOBALS['TSFE']->config['INTincScript'][$substKey] = array(
						'conf'=>$conf,
						'cObj'=>serialize($this->cObj),
						'type'=>'FUNC',
					);
					return $link;
				} else {
					return $this->listView($content, $conf);
				}
				//PRS- 12.08.2005

				return $this->listView($content, $conf);
			break;
		}
	}

	/***************************
	 *
	 * listfunktions
	 *
	 **************************/

	/**
	 * main function for output of the listview and the singleview
	 *
	 * @param	string		$content: main variable carriing the content
	 * @param	array		$conf: config array from typoscript
	 * @return	string		html content
	 */
	function listView($content, $conf) {
		$this->conf = $conf;

		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();

		$this->siteRelPath = $GLOBALS['TYPO3_LOADED_EXT'][$this->extKey]['siteRelPath'];

		$where = '(sys_language_uid = ' . $GLOBALS['TSFE']->sys_language_uid . ' OR sys_language_uid = -1)';
		$where .= $this->cObj->enableFields('tx_macinabanners_banners');

		// nur banner mit dem richtigen placement (left right top bottom) holen
		$allowedPlacements = t3lib_div::trimExplode(',',$conf['placement']);
		if (count($allowedPlacements) > 0) {
			$placementClause = '';

			foreach ($allowedPlacements AS $key => $placement) {
				if (t3lib_div::inList("top,bottom,right,left", $placement)) {
					$allowedPlacements[$key] = $placement;
				} else {
					$catWhere = ' AND description LIKE \'%' . $placement . '%\'';
					$catRS = $this->pi_exec_query('tx_macinabanners_categories', 0, $catWhere, '', '', '');
					$catRow = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($catRS);
					$allowedPlacements[$key] = 'tx_macinabanners_categories:' . $catRow['uid'];
				}
				if ($placementClause != '')
					$placementClause .= ", '" . $allowedPlacements[$key] . "'";
				else
					$placementClause .= "'" . $allowedPlacements[$key] . "'";
			}
			$where .= ' AND placement IN (' . $placementClause . ') ';
		}

		// all records which dont have their id in  excludepages
		$where .= " AND NOT ( excludepages regexp '[[:<:]]".$GLOBALS['TSFE']->id."[[:>:]]' )";

		// FIX pidList beachten !! Fuer Version 1.5.2
		if (!empty($conf['pidList'])) {
			if (!empty($conf['pidList.'])) {
				$where .= ' AND pid IN ('.$this->cObj->cObjGetSingle($conf['pidList'],$conf['pidList.']).') ';
			}
			else {
				$where .= ' AND pid IN ('.$GLOBALS['TYPO3_DB']->cleanIntList($conf['pidList']).') ';
			}
		}

		$orderBy = 'sorting';

		//medialights
		$queryPerformed = true;
		//Prepare and execute listing query
		if (isset($conf['enableParameterRestriction']) && !empty($conf['enableParameterRestriction'])) {
			//show only banners that match to the selected options
			$parameters = array();

			//get banners list according to parameters
			$RS = $GLOBALS['TYPO3_DB']->exec_SELECTquery('uid, parameters', 'tx_macinabanners_banners', $where, '', $orderBy);
			while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($RS)) {
				if (!empty($row['parameters'])) {
					$lines = t3lib_div::trimExplode(chr(10), $row['parameters']);
					foreach ($lines AS $line) {
						list($parameterName, $details) = t3lib_div::trimExplode('=', $line);
						$values = t3lib_div::trimExplode(",", $details);

						foreach ($values AS $value) {
							if (isset($parameters[$parameterName][$value])) {
								$parameters[$parameterName][$value] .= ',' . $row['uid'];
							} else {
								$parameters[$parameterName][$value] = $row['uid'];
							}
						}
					}
				}
			}

			//get parameters
			$currentParameters = t3lib_div::_GET() + t3lib_div::_POST();

			$ids = '';
			foreach ($currentParameters as $parameter => $value) {
				if (!empty($value) && isset($parameters[$parameter][$value])) {
					if ($ids != '') {
						$ids .= ',';
					}
					$ids .= $parameters[$parameter][$value];
				}
			}

			if ($ids != '') {
				$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*', 'tx_macinabanners_banners', 'uid IN ('.$ids.')');
			} else {
				$queryPerformed = false;
			}

		} else {
			//show all banners
			$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*', 'tx_macinabanners_banners', $where, '', $orderBy);
		}

		// for caching
		$parentArr = array();

		// banner aussortieren
		$bannerdata = array();
		while ($queryPerformed && $row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {

			if ($row['pages'] && $row['recursiv']){ // wenn pages nicht leer und rekursiv angehakt ist

				// generiert zur aktuellen Seite alle Elternseiten und prueft ob in der Schnittemenge der
				// Elternseiten mit der erlaubten Bannerseiten mindestens ein Eintrag drinnen ist.
				if (count($parentArr) == 0) {
					foreach ($GLOBALS['TSFE']->tmpl->rootLine as $tmp) {
						$parentArr[] = $tmp['uid'];
					}
				}

				$bannerPidArr = array_unique(t3lib_div::trimExplode(',', $row['pages'], 1));
				$diffArr = array_intersect($parentArr, $bannerPidArr);

				if (count($diffArr) > 0) {
					$bannerdata[] = $row;
				}
			} elseif ($row['pages'] && !$row['recursiv']){
				// wenn pages nicht leer und rekursiv nicht angehakt ist
				$pidArray = array_unique(t3lib_div::trimExplode(',', $row['pages'], 1));
				if (in_array($GLOBALS['TSFE']->id, $pidArray)){
					$bannerdata[] = $row;
				}
			} else {
				// wenn pages leer und rekursiv nicht angehakt ist
				$bannerdata[] = $row;
			}
		}

		$count = count($bannerdata);
		if ($conf['mode'] == 'random' && $count > 1) {
			$randomselectnum = rand(0, $count - 1);
			$randombanner = $bannerdata[$randomselectnum];
			unset($bannerdata);
			$bannerdata[] = $randombanner;
		} elseif ($conf['mode'] == 'random_all' && $count > 1) {
			shuffle($bannerdata);
		}

		// get template
		$this->templateCode = $this->cObj->fileResource($this->conf['templateFile']);

		// get main subpart
		$templateMarker = '###template_banners###';
		$template = array();
		$template = $this->cObj->getSubpart($this->templateCode, $templateMarker);

		// get row subpart
		$rowmarker = '###row###';
		$tablerowarray = array();
		$tablerowarray = $this->cObj->getSubpart($template, $rowmarker);

		$rowdata = '';

		// limit number of banners shown
		$qt = $conf['results_at_a_time'] < count($bannerdata) ? $conf['results_at_a_time'] : count($bannerdata);

		for ($i=0; $i < $qt; $i++) {
			$row = $bannerdata[$i];

			// update impressionsfeld on rendering banner
			$GLOBALS['TYPO3_DB']->exec_UPDATEquery(
				'tx_macinabanners_banners',
				'uid='.$GLOBALS['TYPO3_DB']->fullQuoteStr($row['uid'], 'tx_macinabanners_banners'),
				array('impressions' => ++$row['impressions'])
			);

			// assign borders to array
			$styles = array(
				'margin-top' => $row['border_top'],
				'margin-right' => $row['border_right'],
				'margin-bottom' => $row['border_bottom'],
				'margin-left' => $row['border_left']
			);

			switch($row['bannertype']) {
				case 0:
					/*
					 * Grafik per Typoscript nach belieben zu konfigurieren
					 * Danke an Gernot Ploiner
					 */
					$img = $this->conf['image.'];
					$img['file'] = 'uploads/tx_macinabanners/' . $row['image'];
					$img['alttext'] = $row['alttext'];

					$this->ImageName = 'uploads/tx_macinabanners/' . $row['image'];
					array_walk_recursive($img, array($this, 'replace_field_image'));

					$this->AltText = $row['alttext'];
					array_walk_recursive($img, array($this, 'replace_field_alttext'));

					$img = $this->cObj->IMAGE($img);

					// link image with pagelink und banneruid as getvar
					if ($row['url']) {
						$linkArray = explode(' ', $row['url']);
						$wrappedSubpartArray['###bannerlink###'] = t3lib_div::trimExplode("|", $this->cObj->getTypoLink("|", $GLOBALS['TSFE']->id . " " . $linkArray[1] , array( "no_cache" => 1 , $this->prefixId . "[banneruid]" => $row['uid'] ) ) );
						$banner = join($wrappedSubpartArray['###bannerlink###'], $img);
					} else {
						$banner = $img;
					}
					break;
				case 1:
					if ($row['url']) {
						$linkArray = explode(' ', $row['url']);
						$clickTAG = t3lib_div::getIndpEnv('TYPO3_SITE_URL') . $this->cObj->getTypoLink_URL( $GLOBALS['TSFE']->id, array( "no_cache" => 1 , $this->prefixId . "[banneruid]" => $row['uid'] ) );
					}

					$banner = "\n<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0\" width=\"" . $row['flash_width'] . "\" height=\"" . $row['flash_height'] . "\">\n";
					$banner .= "<param name=\"movie\" value=\"uploads/tx_macinabanners/" . $row['swf'] . "?clickTAG=" . urlencode($clickTAG) . "&amp;target=" . $linkArray[1] . "\" />\n";
					$banner .= "<param name=\"quality\" value=\"autohigh\" />\n";
					$banner .= "<param name=\"allowScriptAccess\" value=\"sameDomain\" />\n";
					$banner .= "<param name=\"menu\" value=\"false\" />\n";
					$banner .= "<param name=\"wmode\" value=\"transparent\" />\n";
					$banner .= "<embed src=\"uploads/tx_macinabanners/" . $row['swf'] . "?clickTAG=" . urlencode($clickTAG) . "&amp;target=" . $linkArray[1] . "\" quality=\"autohigh\" wmode=\"transparent\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\"; type=\"application/x-shockwave-flash\" width=\"" . $row['flash_width'] . "\" height=\"" . $row['flash_height'] . "\"></embed>\n";
					$banner .= "</object>\n";

					break;
				case 2:
					$banner = $row['html'];
					break;
			}

			// funktion to attach styles to wrapping cell
			$banner = $this->wrapwithstyles($banner, $styles);

			// create the content by replacing the marker in the template
			$markerArray = array();
			$markerArray['###banner###'] = $banner;
			$markerArray['###alttext###'] = $row['alttext'];

			if ($row['bannertype'] == 0)
				$markerArray['###filename###'] = $row['image'];
			elseif ($row['bannertype'] == 1)
				$markerArray['###filename###'] = $row['swf'];
			else
				$markerArray['###filename###'] = '';

			$markerArray['###url###'] = $row['url'];
			$markerArray['###impressions###'] = $row['impressions'];
			$markerArray['###clicks###'] = $row['clicks'];
			$markerArray['###edit###'] = $this->pi_getEditPanel($row, 'tx_macinabanners_banners');

			$rowdata .= $this->cObj->substituteMarkerArrayCached($tablerowarray, $markerArray, array(), $wrappedSubpartArray);
		}
		if($rowdata) {
			$subpartArray = array();
			$subpartArray['###row###'] = $rowdata;
			$content = $this->cObj->substituteMarkerArrayCached($template, array(), $subpartArray, array());
			return $content;
		} else {
			return ''; // no banners
		}
	}

	/**
	 * output of a single view element called by pi_list_makelist
	 *
	 * @param	string		$content: main variable carriing the content
	 * @param	array		$conf: config array from typoscript
	 * @return	string		html content
	 */
	function singleView($content, $conf) {
		$this->conf = $conf;

		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();

		switch($this->internal['currentRow']['bannertype']) {
			case 0:
				/*
				 * Grafik per Typoscript nach belieben zu konfigurieren
				 * Danke an Gernot Ploiner
				 */
				$img = $this->conf['image.'];
				$img['file'] = 'uploads/tx_macinabanners/' . $this->internal['currentRow']['image'];
				$img['alttext'] = $this->internal['currentRow']['alttext'];

				$this->ImageName = 'uploads/tx_macinabanners/' . $this->internal['currentRow']['image'];
				array_walk_recursive($img, array($this, 'replace_field_image'));

				$this->AltText = $this->internal['currentRow']['alttext'];
				array_walk_recursive($img, array($this, 'replace_field_alttext'));

				$img = $this->cObj->IMAGE($img);

				// link image with pagelink und banneruid as getvar
				if ( $this->internal['currentRow']['url']) {
					$linkArray = explode(' ', $this->internal['currentRow']['url']);
					$wrappedSubpartArray['###bannerlink###'] = t3lib_div::trimExplode("|", $this->cObj->getTypoLink("|", $GLOBALS['TSFE']->id . " " . $linkArray[1] , array( "no_cache" => 1 , $this->prefixId . "[banneruid]" => $this->internal['currentRow']['uid'] ) ) );
					$banner = join($wrappedSubpartArray['###bannerlink###'], $img);
				} else {
					$banner = $img;
				}
				$content = "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n<tr>\n<td nowrap valign=\"top\">".$banner."</td>\n</tr>\n</table>\n";
				break;

			case 1:
				if ( $this->internal['currentRow']['url']) {
					$linkArray = explode(' ', $this->internal['currentRow']['url']);
					$clickTAG = t3lib_div::getIndpEnv('TYPO3_SITE_URL') . $this->cObj->getTypoLink_URL( $GLOBALS['TSFE']->id, array( "no_cache" => 1 , $this->prefixId . "[banneruid]" =>  $this->internal['currentRow']['uid'] ) );
				}

				$banner = "\n<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0\" width=\"" . $this->internal['currentRow']['flash_width'] . "\" height=\"" . $this->internal['currentRow']['flash_height'] . "\">\n";
				$banner .= "<param name=\"movie\" value=\"uploads/tx_macinabanners/" . $this->internal['currentRow']['swf'] . "?clickTAG=" . urlencode($clickTAG) . "&amp;target=" . $linkArray[1] . "\" />\n";
				$banner .= "<param name=\"quality\" value=\"autohigh\" />\n";
				$banner .= "<param name=\"allowScriptAccess\" value=\"sameDomain\" />\n";
				$banner .= "<param name=\"menu\" value=\"false\" />\n";
				$banner .= "<param name=\"wmode\" value=\"transparent\" />\n";
				$banner .= "<embed src=\"uploads/tx_macinabanners/" . $this->internal['currentRow']['swf'] . "?clickTAG=" . urlencode($clickTAG) . "&amp;target=" . $linkArray[1] . "\" quality=\"autohigh\" wmode=\"transparent\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\"; type=\"application/x-shockwave-flash\" width=\"" . $this->internal['currentRow']['flash_width'] . "\" height=\"" . $this->internal['currentRow']['flash_height'] . "\"></embed>\n";
				$banner .= "</object>\n";
				$content = $banner;
				break;

			case 2:
				$content .= $this->internal['currentRow']['html'];
				break;
		}
		return $content;
	}

	/**
	 * wrapwithstyles wraps the banner with a table that creates the borders left right top and bottom
	 *
	 * @param	string		$string: contains the html bannercode
	 * @param	array		$styles: named array with the styles padding-top, padding bottom ...
	 * @return	string		html content
	 */
	function wrapwithstyles($string, $styles) {
		$content = '<div style="';
		foreach ($styles as $key => $value) {
			$content .= $key . ':' . $value . 'px; ';
		}
		$content .= '">' . $string . "</div>\n";
		return $content;
	}

	function replace_field_image(&$item, $key) {
		if ($item == 'field_image') {
			$item = $this->ImageName;
		}
	}

	function replace_field_alttext(&$item, $key) {
		if ($item == 'field_alttext') {
			$item = $this->AltText;
		}
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/macina_banners/pi1/class.tx_macinabanners_pi1.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/macina_banners/pi1/class.tx_macinabanners_pi1.php']);
}
?>