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
 * Test case.
 *
 * @package TYPO3
 * @subpackage tx_realty
 *
 * @author Saskia Metzler <saskia@merlin.owl.de>
 */
class tx_realty_FrontEnd_ErrorViewTest extends Tx_Phpunit_TestCase {
	/**
	 * @var tx_realty_pi1_ErrorView
	 */
	private $fixture = NULL;
	/**
	 * @var Tx_Oelib_TestingFramework
	 */
	private $testingFramework = NULL;

	protected function setUp() {
		$this->testingFramework = new Tx_Oelib_TestingFramework('tx_realty');
		$this->testingFramework->createFakeFrontEnd(
			$this->testingFramework->createFrontEndPage()
		);

		$this->fixture = new tx_realty_pi1_ErrorView(
			array('templateFile' => 'EXT:realty/pi1/tx_realty_pi1.tpl.htm'),
			$this->getFrontEndController()->cObj
		);
	}

	protected function tearDown() {
		$this->testingFramework->cleanUp();
	}

	/**
	 * Returns the current front-end instance.
	 *
	 * @return tslib_fe
	 */
	private function getFrontEndController() {
		return $GLOBALS['TSFE'];
	}

	/**
	 * @test
	 */
	public function renderReturnsTranslatedMessage() {
		$this->assertContains(
			$this->fixture->translate('message_access_denied'),
			$this->fixture->render(array('message_access_denied'))
		);
	}

	/**
	 * @test
	 */
	public function renderReturnsLinkedPleaseLoginMessage() {
		$this->fixture->setConfigurationValue(
			'loginPID', $this->testingFramework->createFrontEndPage()
		);

		$this->assertContains(
			'<a href',
			$this->fixture->render(array('message_please_login'))
		);
	}

	/**
	 * @test
	 */
	public function renderReturnsPleaseLoginMessageWithLoginPidWithinTheLink() {
		$loginPid = $this->testingFramework->createFrontEndPage();
		$this->fixture->setConfigurationValue('loginPID', $loginPid);

		$this->assertContains(
			'?id=' . $loginPid,
			$this->fixture->render(array('message_please_login'))
		);
	}

	/**
	 * @test
	 */
	public function renderReturnsPleaseLoginMessageWithRedirectUrl() {
		$this->fixture->setConfigurationValue(
			'loginPID', $this->testingFramework->createFrontEndPage()
		);

		$this->assertContains(
			urlencode('?id=' . $this->getFrontEndController()->id),
			$this->fixture->render(array('message_please_login'))
		);
	}

	/**
	 * @test
	 */
	public function renderReturnsWrappingErrorViewSubpart() {
		$this->assertContains(
			'class="error"',
			$this->fixture->render(array('message_access_denied'))
		);
	}

	/**
	 * @test
	 */
	public function renderReturnsNoUnreplacedMarkers() {
		$this->assertNotContains(
			'###',
			$this->fixture->render(array('message_access_denied'))
		);
	}
}