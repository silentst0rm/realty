<?php
/**
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

require_once(t3lib_extMgm::extPath('realty') . 'lib/tx_realty_constants.php');

/**
 * Test case.
 *
 * @package TYPO3
 * @subpackage tx_realty
 *
 * @author Saskia Metzler <saskia@merlin.owl.de>
 */
class tx_realty_Service_TranslatorTest extends tx_phpunit_testcase {
	/**
	 * @var tx_realty_translator instance to be tested
	 */
	private $fixture;

	public function setUp() {
		// No instance to test is created here because different languages are
		// set in the tests. The language must be set before the translator
		// is created.
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function translatorReturnsGermanString() {
		tx_oelib_configurationProxy::getInstance('realty')
			->setAsString('cliLanguage', 'de');
		$this->fixture = new tx_realty_translator();

		$this->assertEquals(
			'Erlaubt',
			$this->fixture->translate('label_allowed')
		);
	}

	/**
	 * @test
	 */
	public function translatorReturnsEnglishString() {
		tx_oelib_configurationProxy::getInstance('realty')
			->setAsString('cliLanguage', 'en');
		$this->fixture = new tx_realty_translator();

		$this->assertEquals(
			'Allowed',
			$this->fixture->translate('label_allowed')
		);
	}

	/**
	 * @test
	 */
	public function translatorReturnsDefaultLanguageStringForInvalidLanguageKey() {
		tx_oelib_configurationProxy::getInstance('realty')
			->setAsString('cliLanguage', 'xy');
		$this->fixture = new tx_realty_translator();

		$this->assertEquals(
			'Allowed',
			$this->fixture->translate('label_allowed')
		);
	}

	/**
	 * @test
	 */
	public function translatorReturnsDefaultLanguageStringForEmptyLanguageKey() {
		tx_oelib_configurationProxy::getInstance('realty')
			->setAsString('cliLanguage', '');
		$this->fixture = new tx_realty_translator();

		$this->assertEquals(
			'Allowed',
			$this->fixture->translate('label_allowed')
		);
	}

	/**
	 * @test
	 */
	public function translatorThrowsAnExceptionForEmptyKey() {
		$this->fixture = new tx_realty_translator();

		$this->setExpectedException(
			'InvalidArgumentException',
			'$key must not be empty.'
		);
		$this->fixture->translate('');
	}
}