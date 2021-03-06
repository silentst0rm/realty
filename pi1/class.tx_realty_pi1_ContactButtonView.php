<?php
/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * This class renders the contact button.
 *
 * @package TYPO3
 * @subpackage tx_realty
 *
 * @author Saskia Metzler <saskia@merlin.owl.de>
 */
class tx_realty_pi1_ContactButtonView extends tx_realty_pi1_FrontEndView {
	/**
	 * Returns the contact button as HTML. For this, requires a "contactPID" to
	 * be configured.
	 *
	 * @param array $piVars
	 *        PiVars array, must contain the key "showUid" with a valid realty object UID or zero as value. Note that for zero,
	 *        the linked contact form will not contain any realty object information.
	 *
	 * @return string HTML for the contact button or an empty string if the
	 *                configured "contactPID" equals the current page or is not
	 *                set at all
	 */
	public function render(array $piVars = array()) {
		if (!$this->hasConfValueInteger('contactPID')
			|| ($this->getConfValueInteger('contactPID') == (int)$this->getFrontEndController()->id)
		) {
			return '';
		}

		$contactUrl = htmlspecialchars($this->cObj->typoLink_URL(array(
			'parameter' => $this->getConfValueInteger('contactPID'),
			'additionalParams' => t3lib_div::implodeArrayForUrl(
				'',
				array($this->prefixId => array('showUid' => $piVars['showUid']))
			),
			'useCacheHash' => TRUE,
		)));
		$this->setMarker('contact_url', $contactUrl);

		return $this->getSubpart('FIELD_WRAPPER_CONTACTBUTTON');
	}
}

if (defined('TYPO3_MODE') && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/realty/pi1/class.tx_realty_pi1_ContactButtonView.php']) {
	include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/realty/pi1/class.tx_realty_pi1_ContactButtonView.php']);
}