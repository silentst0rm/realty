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
 * @subpackage  tx_realty
 *
 * @author Oliver Klee <typo3-coding@oliverklee.de>
 */
class tx_realty_Model_CityTest extends Tx_Phpunit_TestCase {
	/**
	 * @var tx_realty_Model_City
	 */
	private $fixture = NULL;

	protected function setUp() {
		$this->fixture = new tx_realty_Model_City();
	}

	/**
	 * @test
	 */
	public function getTitleWithNonEmptyTitleReturnsTitle() {
		$this->fixture->setData(array('title' => 'London'));

		$this->assertEquals(
			'London',
			$this->fixture->getTitle()
		);
	}

	/**
	 * @test
	 */
	public function setTitleSetsTitle() {
		$this->fixture->setTitle('London');

		$this->assertEquals(
			'London',
			$this->fixture->getTitle()
		);
	}

	/**
	 * @test
	 * @expectedException InvalidArgumentException
	 */
	public function setTitleWithEmptyStringThrowsException() {
		$this->fixture->setTitle('');
	}
}