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
 * This class provides a contact form for the realty plugin.
 *
 * @package TYPO3
 * @subpackage tx_realty
 *
 * @author Saskia Metzler <saskia@merlin.owl.de>
 * @author Oliver Klee <typo3-coding@oliverklee.de>
 */
class tx_realty_contactForm extends tx_realty_pi1_FrontEndView {
	/**
	 * @var array data for the contact form
	 */
	private $contactFormData = array(
		'isSubmitted' => FALSE,
		'showUid' => 0,
		'requesterName' => '',
		'requesterStreet' => '',
		'requesterZip' => '',
		'requesterCity' => '',
		'requesterEmail' => '',
		'requesterPhone' => '',
		'request' => '',
		'viewing' => 0,
		'information' => 0,
		'callback' => 0,
		'terms' => 0,
		'summaryStringOfFavorites' => '',
	);

	/**
	 * Returns the contact form in HTML.
	 * If $contactFormData contains a value greater zero for the element
	 * 'showUid', the contact form will be specific for the current realty
	 * object and the requests are sent directly to the owner (or the contact
	 * person if there is no owner). Otherwise the content is unspecific and
	 * requests always go to the default e-mail address.
	 * The form's content also depends on whether a FE user is logged in or not.
	 * Registered users do not need to fill in their name, e-mail address and
	 * telephone number as they already exist in the database.
	 * If the request has been successfully sent, the HTML string will contain
	 * a message about this, otherwise a specific error message.
	 *
	 * @param array $contactFormData contact form data, may be empty
	 *
	 * @return string HTML of the contact form, will not be empty
	 */
	public function render(array $contactFormData = array()) {
		$this->storeContactFormData($contactFormData);

		// setOrHideSpecializedView() will fail if the 'showUid' parameter is
		// set to an invalid value.
		if (!$this->setOrHideSpecializedView()) {
			$this->setMarker('message_noResultsFound', $this->translate('message_noResultsFound_contact_form'));

			return $this->getSubpart('EMPTY_RESULT_VIEW');
		}

		$this->hideNonVisibleFormFields();

		$subpartName = 'CONTACT_FORM';
		$errorMessages = array(
			'requesterName' => '', 'requesterStreet' => '', 'requesterZip' => '',
			'requesterCity' => '', 'requesterEmail' => '', 'requesterPhone' => '',
			'request' => '', 'terms' => '', 'contact_form' => '',
		);

		$this->fillContactInformationFieldsForLoggedInUser();
		$this->createTermsLink();
		$this->setFormValues();

		if ($this->contactFormData['isSubmitted'] && $this->checkFormData($errorMessages)) {
			if ($this->sendRequest()) {
				$subpartName = 'CONTACT_FORM_SUBMITTED';
			} else {
				$errorMessages['contact_form'] = 'label_no_contact_person';
			}
		}

		$this->setErrorMessageContent($errorMessages);

		return $this->getSubpart($subpartName);
	}

	/**
	 * Hides form fields that are not configured to be visible.
	 *
	 * @return void
	 */
	private function hideNonVisibleFormFields() {
		$visibleFields = $this->getVisibleFields();
		if (in_array('law', $visibleFields)) {
			$visibleFields[] = 'law_asterisk';
		}

		$this->hideSubpartsArray(
			array_diff(
				array(
					'name', 'street', 'zip_and_city', 'telephone', 'request',
					'viewing', 'information', 'callback', 'law_asterisk',
					'terms', 'law',
				),
				$visibleFields
			),
			'contact_form_wrapper'
		);
	}

	/**
	 * Retrieves the names of the visible fields.
	 *
	 * @return string[] the names of the visible fields, will be empty if no optional fields are visible
	 */
	private function getVisibleFields() {
		return $this->getConfigurationArray('visibleContactFormFields');
	}

	/**
	 * Checks whether the form data is correctly filled.
	 *
	 * @param string[] $errorMessages
	 *        associative array with field names as keys, locallang keys of
	 *        error messages will be added as values by this function
	 *
	 * @return bool TRUE if the form data was correctly filled, FALSE otherwise
	 */
	private function checkFormData(array &$errorMessages) {
		$noErrorsSet = TRUE;

		if (!tx_oelib_FrontEndLoginManager::getInstance()->isLoggedIn()) {
			if (!$this->isValidName($this->contactFormData['requesterName'])) {
				$errorMessages['requesterName'] = 'label_set_name';
				$noErrorsSet = FALSE;
			}
			if (!$this->isValidEmail($this->contactFormData['requesterEmail'])) {
				$errorMessages['requesterEmail'] = 'label_set_valid_email_address';
				$noErrorsSet = FALSE;
			}
			$nonFilledRequiredFields = $this->getEmptyRequiredFields();
			if (!empty($nonFilledRequiredFields)) {
				foreach ($nonFilledRequiredFields as $key) {
					$suffix = '';
					if (in_array($key, array('requesterZip', 'requesterCity', 'request', 'terms'))) {
						$suffix = '_' . $key;
					}

					$errorMessages[$key] = 'message_required_field' . $suffix;
				}
				$noErrorsSet = FALSE;
			}
		}

		return $noErrorsSet;
	}

	/**
	 * Returns an array of the form data keys that have empty values but are
	 * configured to be required fields.
	 *
	 * @return string[] keys of form fields that are empty but must not be empty,
	 *               will be empty if all required fields have been filled in
	 */
	private function getEmptyRequiredFields() {
		$result = array();
		$requiredFields = $this->getConfigurationArray('requiredContactFormFields');

		foreach (array(
			'requesterName' => 'name',
			'requesterStreet' => 'street',
			'requesterZip' => 'zip',
			'requesterCity' => 'city',
			'requesterPhone' => 'telephone',
			'request' => 'request',
		) as $formDataKey => $fieldName) {
			if (in_array($fieldName, $requiredFields) && (trim($this->contactFormData[$formDataKey]) == '') ) {
				$result[] = $formDataKey;
			}
		}

		if (in_array('terms', $this->getVisibleFields())
			&& ($this->contactFormData['terms'] != 1)
		) {
			$result[] = 'terms';
		}

		return $result;
	}

	/**
	 * Sends the filled-in request of the contact form to the owner of the
	 * object (or to the contact person if there is no owner).
	 * If a recipient for a blind carbon copy is configured, the request is
	 * also sent to this address.
	 *
	 * Note: When this extension requires TYPO3 4.2, the return value of
	 * sendEmail() should be returned instead of just returning TRUE after
	 * sending an e-mail.
	 *
	 * @return bool TRUE if the contact data for sending an e-mail could be
	 *                 fetched and the send e-mail function was called,
	 *                 FALSE otherwise
	 *
	 * @see https://bugs.oliverklee.com/show_bug.cgi?id=961
	 */
	private function sendRequest() {
		$contactData = $this->getContactData();
		if (($contactData['email'] == '') || !$this->setOrHideSpecializedView()) {
			return FALSE;
		}

		$contactName = $contactData['name'];
		/** @var t3lib_mail_Message $email */
		$email = t3lib_div::makeInstance('t3lib_mail_Message');
		$email->setTo(array($contactData['email'] => $contactName));
		$email->setSubject($this->getEmailSubject());
		$email->setBody($this->getFilledEmailBody($contactName));
		$email->setFrom(array($this->contactFormData['requesterEmail'] => $this->contactFormData['requesterName']));

		if ($this->hasConfValueString('blindCarbonCopyAddress', 's_contactForm')) {
			$bccAddress = $this->getConfValueString('blindCarbonCopyAddress', 's_contactForm');
			$email->setBcc(array($bccAddress => ''));
		}

		$email->send();

		return TRUE;
	}

	/**
	 * Returns the e-mail body. It contains the request and the requester's
	 * contact data.
	 *
	 * @param string $contactPerson name of the contact person, must not be empty
	 *
	 * @return string the body of the e-mail to send, contains the request and
	 *                the contact data of the requester, will not be empty
	 */
	private function getFilledEmailBody($contactPerson) {
		foreach (array(
			'request' => $this->contactFormData['request'],
			'requester_name' => $this->contactFormData['requesterName'],
			'requester_email' => $this->contactFormData['requesterEmail'],
			'requester_phone' => $this->contactFormData['requesterPhone'],
			'requester_street' => $this->contactFormData['requesterStreet'],
			'requester_zip_and_city' => trim(
					$this->contactFormData['requesterZip'] . ' ' . $this->contactFormData['requesterCity']
				),
			'summary_string_of_favorites' => $this->contactFormData['summaryStringOfFavorites'],
			'contact_person' => $contactPerson,
		) as $marker => $value) {
			$this->setOrDeleteMarkerIfNotEmpty($marker, $value, '', 'wrapper');
		}

		$this->setOrDeleteMarkerIfNotEmpty('email_checkboxes', $this->getCheckboxesForEMail(), '', 'wrapper');

		return $this->getSubpart('EMAIL_BODY');
	}

	/**
	 * Returns the texts concerning the checked checkboxes prepared for e-mail.
	 *
	 * @return string the checkboxes texts separated by LF, will be empty if no
	 *                checkboxes have been checked
	 */
	private function getCheckboxesForEMail() {
		$result = array();

		foreach (array('viewing', 'information', 'callback') as $key) {
			if ($this->contactFormData[$key] == 1) {
				$result[] = $this->translate('label_' . $key);
			}
		}
		if ($this->contactFormData['terms'] == 1) {
			// The label might have an acronym tag in it and %s markers for
			// the anchor tag which need to get removed.
			$result[] = strip_tags(
				str_replace(' %s', '', $this->translate('label_terms'))
			);
		}

		return implode(LF, $result);
	}

	/**
	 * Returns the subject for the e-mail to send. It depends on the type of
	 * contact form whether the object number will be included.
	 *
	 * @return string the e-mail's subject, will not be empy
	 */
	private function getEmailSubject() {
		if ($this->isSpecializedView()) {
			$result = $this->translate('label_email_subject_specialized') .
				' ' . $this->getRealtyObject()->getProperty('object_number');
		} else {
			$result = $this->translate('label_email_subject_general');
		}

		return $result;
	}

	/**
	 * Sets the requester's data if the requester is a logged in user. Does
	 * nothing if no user is logged in.
	 *
	 * @return void
	 */
	private function setDataForLoggedInUser() {
		if (!tx_oelib_FrontEndLoginManager::getInstance()->isLoggedIn()) {
			return;
		}

		$visibilityKeysForFormData = array(
			'requesterName' => 'name',
			'requesterStreet' => 'street',
			'requesterPhone' => 'telephone',
			'requesterZip' => 'zip_and_city',
			'requesterCity' => 'zip_and_city',
		);
		$visibleFields = array_intersect($visibilityKeysForFormData, $this->getVisibleFields());

		$loggedInUser = tx_oelib_FrontEndLoginManager::getInstance()->getLoggedInUser('tx_realty_Mapper_FrontEndUser');
		foreach (array(
			'requesterName' => 'getName',
			'requesterStreet' => 'getStreet',
			'requesterZip' => 'getZip',
			'requesterCity' => 'getCity',
			'requesterEmail' => 'getEMailAddress',
			'requesterPhone' => 'getPhoneNumber',
		) as $contactFormDataKey => $functionName) {
			if (isset($visibleFields[$contactFormDataKey]) || ($contactFormDataKey == 'requesterEmail')) {
				$this->contactFormData[$contactFormDataKey] = $loggedInUser->$functionName();
			}
		}
	}

	/**
	 * Returns an array of configuration value that is a comma-separated list in
	 * the s_contactForm sheet.
	 *
	 * @param string $key key of the configuration value to get as an array, must not be empty
	 *
	 * @return string[] configuration of $key, empty if no configuration was found
	 */
	private function getConfigurationArray($key) {
		return t3lib_div::trimExplode(',', $this->getConfValueString($key, 's_contactForm'), TRUE);
	}

	/**
	 * Returns the name and e-mail address of the contact person in an
	 * associative array with the keys 'name' and 'email'.
	 * According to 'contact_data_source', either the owner's account data or
	 * the data from the realty object ('contact_email' and 'contact_person')
	 * is used.
	 *
	 * If the fetched e-mail address is invalid, the configured default e-mail
	 * address is returned instead. The result then will not contain a name.
	 *
	 * If no contact person's data could be fetched and no default e-mail
	 * address is configured, an empty array is returned.
	 *
	 * @return string[] owner or contact person and the corresponding
	 *               e-mail address in an array, contains the default
	 *               e-mail address if no valid address was found, empty
	 *               if the expected contact data was not found
	 */
	private function getContactData() {
		$result = array('name' => '', 'email' => '');
		$contactData = $this->fetchContactDataFromSource();

		if ($this->isValidEmail($contactData['email'])) {
			$result = $contactData;
		} elseif ($this->hasConfValueString('defaultContactEmail', 's_contactForm')) {
			$result['email'] = $this->getConfValueString('defaultContactEmail', 's_contactForm');
		}

		return $result;
	}

	/**
	 * Fetches the contact data from the source defined in the realty record and
	 * returns it in an array.
	 *
	 * @return string[] contact data array, will always contain the two elements 'email' and 'name'
	 */
	private function fetchContactDataFromSource() {
		if (!$this->isSpecializedView()) {
			return array('email' => '', 'name' => '');
		}

		try {
			$realtyObject = $this->getRealtyObject();
			$contactData = array(
				'email' => $realtyObject->getContactEMailAddress(),
				'name' => $realtyObject->getContactName(),
			);
		} catch (tx_oelib_Exception_NotFound $exception) {
			$contactData = array('email' => '', 'name' => '');
		}

		return $contactData;
	}

	/**
	 * Sets or hides the specialized contact form.
	 *
	 * @return bool FALSE if the specialized contact form is supposed to
	 *                 be set but no object data could be fetched, TRUE
	 *                 otherwise
	 */
	private function setOrHideSpecializedView() {
		$wasSuccessful = TRUE;

		if ($this->isSpecializedView()) {
			$subpartsToHide = 'email_from_general_contact_form';

			/** @var tx_realty_Mapper_RealtyObject $mapper */
			$mapper = Tx_Oelib_MapperRegistry::get('tx_realty_Mapper_RealtyObject');
			if (!$mapper->existsModel($this->getShowUid())) {
				$wasSuccessful = FALSE;
			} else {
				foreach (array('object_number', 'title', 'uid') as $key) {
					$value = ($key == 'uid')
						? $this->getRealtyObject()->getUid()
						: $this->getRealtyObject()->getProperty($key);
					$this->setMarker($key, $value, '', 'wrapper');
				}
			}
		} else {
			$subpartsToHide = 'specialized_contact_form,' . 'email_from_specialized_contact_form';
		}

		$this->hideSubparts($subpartsToHide, 'wrapper');

		return $wasSuccessful;
	}

	/**
	 * Declares the fields for the requester's contact data as not editable and
	 * fills them with the current FE user's data if a user is logged in.
	 *
	 * @return void
	 */
	private function fillContactInformationFieldsForLoggedInUser() {
		$readonlyMarkerContent = '';
		if (tx_oelib_FrontEndLoginManager::getInstance()->isLoggedIn()) {
			$readonlyMarkerContent = 'disabled="disabled"';
			$this->setDataForLoggedInUser();
		} else {
			$this->hideSubparts('requester_data_is_uneditable', 'wrapper');
		}
		$this->setMarker('declare_uneditable', $readonlyMarkerContent);
	}

	/**
	 * Sets an error message to the marker 'ERROR_MESSAGE'.
	 *
	 * @param string[] $errors
	 *        associative array with the fields where the error occurred as keys
	 *        and the locallang key of an error message as value if there was
	 *        one, must not be empty
	 *
	 * @return void
	 */
	private function setErrorMessageContent(array $errors) {
		foreach ($errors as $formFieldName => $locallangKey) {
			if ($locallangKey != '') {
				$this->setMarker('ERROR_MESSAGE', $this->translate($locallangKey) . '<br/>');
				$formattedError = $this->getSubpart('CONTACT_FORM_ERROR');
			} else {
				$formattedError = '';
			}

			$this->setMarker(strtoupper($formFieldName) . '_ERROR', $formattedError);
		}
	}

	/**
	 * Checks whether the specialized view should be set.
	 *
	 * @return bool TRUE if the view should be specialized, FALSE otherwise
	 */
	private function isSpecializedView() {
		return ($this->getShowUid() > 0);
	}

	/**
	 * Checks whether an e-mail address is valid.
	 *
	 * @param string $emailAddress e-mail address to check, may be empty
	 *
	 * @return bool TRUE if the e-mail address is valid, FALSE otherwise
	 */
	private function isValidEmail($emailAddress) {
		return (($emailAddress != '') && t3lib_div::validEmail($emailAddress));
	}

	/**
	 * Checks whether a name is non-empty and valid.
	 *
	 * @param string $name the name to check, may be empty
	 *
	 * @return bool TRUE if the name is valid which means it does not contain
	 *                 any characters that are indicative of header injection,
	 *                 FALSE otherwise
	 */
	private function isValidName($name) {
		if ($name == '') {
			return TRUE;
		}

		return (bool) preg_match('/^[\S ]+$/s', $name) && !preg_match('/[<>"]/', $name);
	}

	/**
	 * Creates the link and label to the terms and sets its as a marker content
	 * in the template.
	 *
	 * This function is a no-op if the "terms" checkbox is not configured to be
	 * displayed.
	 *
	 * @return void
	 */
	private function createTermsLink() {
		if (!in_array('terms', $this->getConfigurationArray('visibleContactFormFields'), true)) {
			return;
		}

		$termsPid = $this->getConfValueInteger('termsPID', 's_contactForm');
		$termsUrl = $this->cObj->getTypoLink_URL($termsPid);
		$linkStart = '<a href="' . $termsUrl . '" onclick="window.open(\''. $termsUrl . '\'); return FALSE;">';
		$linkEnd = '</a>';

		$label = sprintf($this->translate('label_terms'), $linkStart, $linkEnd);

		$this->setMarker('label_terms_with_link', $label);
	}

	/**
	 * Sets the form fields' values to the currently stored form data.
	 * Therefore converts special characters to HTML entities.
	 *
	 * @return void
	 */
	private function setFormValues() {
		foreach (array(
			'request' => $this->contactFormData['request'],
			'requester_name' => $this->contactFormData['requesterName'],
			'requester_street' => $this->contactFormData['requesterStreet'],
			'requester_zip' => $this->contactFormData['requesterZip'],
			'requester_city' => $this->contactFormData['requesterCity'],
			'requester_email' => $this->contactFormData['requesterEmail'],
			'requester_phone' => $this->contactFormData['requesterPhone'],
		) as $marker => $value) {
			$this->setMarker($marker, htmlspecialchars($value));
		}

		foreach (array(
			'viewing' => $this->contactFormData['viewing'],
			'information' => $this->contactFormData['information'],
			'callback' => $this->contactFormData['callback'],
			'terms' => $this->contactFormData['terms'],
		) as $key => $value) {
			$checked = ($value == 1) ? 'checked="checked" ' : '';
			$this->setMarker($key, $checked, 'checked');
		}

	}

	/**
	 * Stores the submitted contact form data locally.
	 *
	 * @param array $contactFormData contact form data, may be empty
	 *
	 * @return void
	 */
	private function storeContactFormData(array $contactFormData) {
		foreach (
			array(
				'requesterName', 'requesterStreet', 'requesterZip',
				'requesterCity', 'requesterEmail', 'requesterPhone', 'request',
			) as $key
		) {
			$this->contactFormData[$key] = isset($contactFormData[$key]) ? trim($contactFormData[$key]) : '';
		}
		foreach (array('viewing', 'information', 'callback', 'terms') as $key) {
			$this->contactFormData[$key] = isset($contactFormData[$key]) ? (int) $contactFormData[$key] : 0;
		}

		$this->contactFormData['isSubmitted'] = isset($contactFormData['isSubmitted'])
			? (bool) $contactFormData['isSubmitted'] : FALSE;
		$this->contactFormData['showUid'] = isset($contactFormData['showUid']) ? (int) $contactFormData['showUid'] : 0;
		$this->contactFormData['summaryStringOfFavorites'] = isset($contactFormData['summaryStringOfFavorites'])
			? $contactFormData['summaryStringOfFavorites'] : '';
	}

	/**
	 * Returns the current "showUid".
	 *
	 * @return int UID of the current realty object, will be >= 0
	 */
	private function getShowUid() {
		return $this->contactFormData['showUid'];
	}

	/**
	 * Gets the realty object for the "showUid" defined in the contact data
	 * array.
	 *
	 * @return tx_realty_Model_RealtyObject realty object for current UID
	 */
	private function getRealtyObject() {
		/** @var tx_realty_Mapper_RealtyObject $mapper */
		$mapper = Tx_Oelib_MapperRegistry::get('tx_realty_Mapper_RealtyObject');
		return $mapper->find($this->getShowUid());
	}
}

if (defined('TYPO3_MODE') && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/realty/pi1/class.tx_realty_contactForm.php']) {
	include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/realty/pi1/class.tx_realty_contactForm.php']);
}