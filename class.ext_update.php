<?php
/***************************************************************
* Copyright notice
*
* (c) 2009 Oliver Klee <typo3-coding@oliverklee.de>
* All rights reserved
*
* This script is part of the TYPO3 project. The TYPO3 project is
* free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
*
* The GNU General Public License can be found at
* http://www.gnu.org/copyleft/gpl.html.
*
* This script is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

if (t3lib_extMgm::isLoaded('oelib')) {
	require_once(t3lib_extMgm::extPath('oelib') . 'class.tx_oelib_Autoloader.php');
}

/**
 * Class ext_update for the "realty" extension.
 *
 * This class offers functions to update the database from one version to
 * another and to reorganize the district-city relations.
 *
 * @package TYPO3
 * @subpackage tx_realty
 *
 * @author Oliver Klee <typo3-coding@oliverklee.de>
 */
class ext_update {
	/**
	 * Returns the update module content.
	 *
	 * @return string the update module content, will be empty if nothing was
	 *                updated
	 */
	public function main() {
		$result = '';

		try {
			if ($this->needsToUpdateDistricts()) {
				$result = $this->updateDistricts();
			}
		} catch (tx_oelib_Exception_Database $exception) {
		}

		return $result;
	}

	/**
	 * Returns whether the update module may be accessed.
	 *
	 * @return boolean TRUE if the update module may be accessed, FALSE otherwise
	 */
	public function access() {
		if (
			!t3lib_extMgm::isLoaded('oelib') || !t3lib_extMgm::isLoaded('realty')
		) {
			return FALSE;
		}
		if (!tx_oelib_db::existsTable('tx_realty_objects')
			|| !tx_oelib_db::existsTable('tx_realty_cities')
			|| !tx_oelib_db::existsTable('tx_realty_districts')
		) {
			return FALSE;
		}
		if (!tx_oelib_db::tableHasColumn('tx_realty_districts', 'city')) {
			return FALSE;
		}

		try {
			$result = $this->needsToUpdateDistricts();
		} catch (tx_oelib_Exception_Database $exception) {
			$result = FALSE;
		}

		return $result;
	}

	/**
	 * Checks whether the district -> city relations need to be updated.
	 */
	private function needsToUpdateDistricts() {
		$districtsWithExactlyOneCity = $this->findDistrictsToAssignCity();

		return !empty($districtsWithExactlyOneCity);
	}

	/**
	 * Updates the district -> city relations.
	 *
	 * @return string output of the update function, will not be empty
	 */
	private function updateDistricts() {
		$result = '<h2>Updating district-city relations:</h2>' . LF .
			'<table summary="districts and cities">' . LF .
			'<thead>' . LF .
			'<tr><th>District</th><th>City</th></tr>' . LF .
			'</thead>' . LF .
			'<tbody>' . LF;

		$cityCache = array();

		foreach ($this->findDistrictsToAssignCity() as $uids) {
			$districtUid = $uids['district'];
			$cityUid = $uids['city'];

			tx_oelib_db::update(
				'tx_realty_districts', 'uid = ' . $districtUid,
				array('city' => $cityUid)
			);

			$district = tx_oelib_db::selectSingle(
				'title', 'tx_realty_districts', 'uid = ' . $districtUid
			);
			if (!isset($cityCache[$cityUid])) {
				$city = tx_oelib_db::selectSingle(
					'title',  'tx_realty_cities', 'uid = ' . $cityUid
				);

				$cityCache[$cityUid] = $city['title'];
			}

			$result .= '<tr><td>' . htmlspecialchars($district['title']) .
				'</td><td>' . htmlspecialchars($cityCache[$cityUid]) .
				'</td></tr>' . LF;
		}


		$result .= '</tbody>' . LF . '</table>';

		return $result;
	}

	/**
	 * Finds all districts that have no city assigned yet, but have have exactly
	 * one city in the objects table.
	 *
	 * @return array two-dimensional array, the second dimension having the keys
	 *               "city" and "district" with the corresponding UIDs, will be
	 *               empty if there are no matches
	 */
	private function findDistrictsToAssignCity() {
		$districtsWithoutCity = tx_oelib_db::selectColumnForMultiple(
			'uid', 'tx_realty_districts',
			'city = 0' . tx_oelib_db::enableFields('tx_realty_districts')
		);
		if (empty($districtsWithoutCity)) {
			return array();
		}

		return tx_oelib_db::selectMultiple(
			'city, district',
			'tx_realty_objects',
			'district IN ('. implode(',', $districtsWithoutCity) . ') AND city > 0' .
				tx_oelib_db::enableFields('tx_realty_objects'),
			'district HAVING COUNT(DISTINCT city) = 1',
			'city'
		);
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/realty/class.ext_update.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/realty/class.ext_update.php']);
}
?>