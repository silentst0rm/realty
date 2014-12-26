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
 * @author Oliver Klee <typo3-coding@oliverklee.de>
 */
class tx_realty_FrontEnd_SingleViewTest extends tx_phpunit_testcase {
	/**
	 * @var tx_realty_pi1_SingleView
	 */
	private $fixture;

	/**
	 * @var tx_oelib_testingFramework
	 */
	private $testingFramework;

	/**
	 * @var int UID of the dummy realty object
	 */
	private $realtyUid = 0;

	/**
	 * the UID of a dummy city for the object records
	 *
	 * @var int
	 */
	private $dummyCityUid = 0;

	protected function setUp() {
		$this->testingFramework = new tx_oelib_testingFramework('tx_realty');
		$this->testingFramework->createFakeFrontEnd();

		$this->fixture = new tx_realty_pi1_SingleView(
			array('templateFile' => 'EXT:realty/pi1/tx_realty_pi1.tpl.htm'),
			$GLOBALS['TSFE']->cObj,
			TRUE
		);
		$this->fixture->setConfigurationValue(
			'singleViewPartsToDisplay',
			'heading,address,description,documents,furtherDescription,price,' .
				'overviewTable,imageThumbnails,addToFavoritesButton,' .
				'contactButton,offerer,status,printPageButton,backButton'
		);
		$this->dummyCityUid = $this->testingFramework->createRecord('tx_realty_cities');

		$pluginConfiguration = new Tx_Oelib_Configuration();
		Tx_Oelib_ConfigurationRegistry::getInstance()->set('plugin.tx_realty_pi1', $pluginConfiguration);
		$imagesConfiguration = new Tx_Oelib_Configuration();
		Tx_Oelib_ConfigurationRegistry::getInstance()->set('plugin.tx_realty_pi1.images', $imagesConfiguration);
	}

	protected function tearDown() {
		$this->testingFramework->cleanUp();
	}


	/////////////////////////////////////////////////////
	// Testing the conditions to render the single view
	/////////////////////////////////////////////////////

	/**
	 * @test
	 */
	public function singleViewReturnsEmptyResultForZeroShowUid() {
		$this->assertEquals(
			'',
			$this->fixture->render(array('showUid' => 0))
		);
	}

	/**
	 * @test
	 */
	public function singleViewReturnsEmptyResultForShowUidOfDeletedRecord() {
		$realtyObject = tx_oelib_MapperRegistry::get('tx_realty_Mapper_RealtyObject')
			->getNewGhost();
		$realtyObject->setToDeleted();

		$this->assertEquals(
			'',
			$this->fixture->render(array('showUid' => $realtyObject->getUid()))
		);
	}

	/**
	 * @test
	 */
	public function singleViewReturnsEmptyResultForShowUidOfHiddenRecordAndNoUserLoggedIn() {
		$realtyObject = tx_oelib_MapperRegistry::get('tx_realty_Mapper_RealtyObject')
			->getLoadedTestingModel(array('hidden' => 1));
		$this->assertEquals(
			'',
			$this->fixture->render(array('showUid' => $realtyObject->getUid()))
		);
	}

	/**
	 * @test
	 */
	public function singleViewReturnsEmptyResultForShowUidOfHiddenRecordNonOwnerLoggedIn() {
		$userMapper = tx_oelib_MapperRegistry
			::get('tx_realty_Mapper_FrontEndUser');
		$owner = $userMapper->getNewGhost();
		$realtyObject = tx_oelib_MapperRegistry::get('tx_realty_Mapper_RealtyObject')
			->getLoadedTestingModel(array(
				'hidden' => 1,
				'owner' => $owner->getUid(),
			));

		tx_oelib_FrontEndLoginManager::getInstance()
			->logInUser($userMapper->getNewGhost());

		$this->assertEquals(
			'',
			$this->fixture->render(array('showUid' => $realtyObject->getUid()))
		);
	}

	/**
	 * @test
	 */
	public function singleViewReturnsNonEmptyResultForShowUidOfHiddenRecordOwnerLoggedIn() {
		$userMapper = tx_oelib_MapperRegistry
			::get('tx_realty_Mapper_FrontEndUser');
		$owner = $userMapper->getNewGhost();
		$realtyObject = tx_oelib_MapperRegistry::get('tx_realty_Mapper_RealtyObject')
			->getLoadedTestingModel(array(
				'hidden' => 1,
				'owner' => $owner->getUid(),
			));
		tx_oelib_FrontEndLoginManager::getInstance()->logInUser($owner);

		$this->assertNotEquals(
			'',
			$this->fixture->render(array('showUid' => $realtyObject->getUid()))
		);
	}

	/**
	 * @test
	 */
	public function singleViewReturnsNonEmptyResultForShowUidOfExistingRecord() {
		$realtyObject = tx_oelib_MapperRegistry::get('tx_realty_Mapper_RealtyObject')
			->getLoadedTestingModel(array('title' => 'foo'));

		$this->assertNotEquals(
			'',
			$this->fixture->render(array('showUid' => $realtyObject->getUid()))
		);
	}

	/**
	 * @test
	 */
	public function singleViewReturnsNoUnreplacedMarkersWhileTheResultIsNonEmpty() {
		$realtyObject = tx_oelib_MapperRegistry::get('tx_realty_Mapper_RealtyObject')
			->getLoadedTestingModel(array('title' => 'foo'));

		$this->assertNotContains(
			'###',
			$this->fixture->render(array('showUid' => $realtyObject->getUid()))
		);
	}


	///////////////////////////////////////////////
	// Testing the different view parts displayed
	///////////////////////////////////////////////

	/**
	 * @test
	 */
	public function singleViewDisplaysTheTitleOfARealtyObjectIfEnabled() {
		$realtyObject = tx_oelib_MapperRegistry::get('tx_realty_Mapper_RealtyObject')
			->getLoadedTestingModel(array('title' => 'foo'));

		$this->fixture->setConfigurationValue(
			'singleViewPartsToDisplay', 'heading'
		);

		$this->assertContains(
			'foo',
			$this->fixture->render(array('showUid' => $realtyObject->getUid()))
		);
	}

	/**
	 * @test
	 */
	public function singleViewNotDisplaysTheTitleOfARealtyObjectIfDisabled() {
		$realtyObject = tx_oelib_MapperRegistry::get('tx_realty_Mapper_RealtyObject')
			->getLoadedTestingModel(array('title' => 'foo'));

		$this->fixture->setConfigurationValue(
			'singleViewPartsToDisplay', 'description'
		);

		$this->assertNotContains(
			'foo',
			$this->fixture->render(array('showUid' => $realtyObject->getUid()))
		);
	}

	/**
	 * @test
	 */
	public function singleViewDisplaysTheDescriptionOfARealtyObjectIfEnabled() {
		$realtyObject = tx_oelib_MapperRegistry::get('tx_realty_Mapper_RealtyObject')
			->getLoadedTestingModel(array('description' => 'foo'));

		$this->fixture->setConfigurationValue(
			'singleViewPartsToDisplay', 'description'
		);

		$this->assertContains(
			'foo',
			$this->fixture->render(array('showUid' => $realtyObject->getUid()))
		);
	}

	/**
	 * @test
	 */
	public function singleViewNotDisplaysTheDescriptionOfARealtyObjectIfDisabled() {
		$realtyObject = tx_oelib_MapperRegistry::get('tx_realty_Mapper_RealtyObject')
			->getLoadedTestingModel(array('description' => 'foo'));

		$this->fixture->setConfigurationValue(
			'singleViewPartsToDisplay', 'heading'
		);

		$this->assertNotContains(
			'foo',
			$this->fixture->render(array('showUid' => $realtyObject->getUid()))
		);
	}

	/**
	 * @test
	 */
	public function singleViewDisplaysTheDocumentsOfARealtyObjectIfEnabled() {
		$realtyObject = tx_oelib_MapperRegistry::get('tx_realty_Mapper_RealtyObject')
			->getLoadedTestingModel(array());
		$realtyObject->addDocument('new document', 'readme.pdf');

		$this->fixture->setConfigurationValue(
			'singleViewPartsToDisplay', 'documents'
		);

		$this->assertContains(
			'new document',
			$this->fixture->render(array('showUid' => $realtyObject->getUid()))
		);
	}

	/**
	 * @test
	 */
	public function singleViewNotDisplaysTheDocumentsOfARealtyObjectIfDisabled() {
		$realtyObject = tx_oelib_MapperRegistry::get('tx_realty_Mapper_RealtyObject')
			->getLoadedTestingModel(array());
		$realtyObject->addDocument('new document', 'readme.pdf');

		$this->fixture->setConfigurationValue(
			'singleViewPartsToDisplay', 'heading'
		);

		$this->assertNotContains(
			'new document',
			$this->fixture->render(array('showUid' => $realtyObject->getUid()))
		);
	}

	/**
	 * @test
	 */
	public function singleViewDisplaysThePriceOfARealtyObjectIfEnabled() {
		$realtyObject = tx_oelib_MapperRegistry::get('tx_realty_Mapper_RealtyObject')
			->getLoadedTestingModel(array(
				'object_type' => tx_realty_Model_RealtyObject::TYPE_FOR_SALE,
				'buying_price' => '123',
		));

		$this->assertContains(
			'123',
			$this->fixture->render(array('showUid' => $realtyObject->getUid()))
		);
	}

	/**
	 * @test
	 */
	public function singleViewNotDisplaysThePriceOfARealtyObjectIfDisabled() {
		$realtyObject = tx_oelib_MapperRegistry::get('tx_realty_Mapper_RealtyObject')
			->getLoadedTestingModel(array(
				'object_type' => tx_realty_Model_RealtyObject::TYPE_FOR_SALE,
				'buying_price' => '123',
		));

		$this->fixture->setConfigurationValue(
			'singleViewPartsToDisplay', 'heading'
		);

		$this->assertNotContains(
			'123',
			$this->fixture->render(array('showUid' => $realtyObject->getUid()))
		);
	}

	/**
	 * @test
	 */
	public function singleViewDisplaysTheEquipmentDescriptionOfARealtyObjectIfEnabled() {
		$realtyObject = tx_oelib_MapperRegistry::get('tx_realty_Mapper_RealtyObject')
			->getLoadedTestingModel(array('equipment' => 'foo'));

		$this->fixture->setConfigurationValue(
			'singleViewPartsToDisplay', 'furtherDescription'
		);

		$this->assertContains(
			'foo',
			$this->fixture->render(array('showUid' => $realtyObject->getUid()))
		);
	}

	/**
	 * @test
	 */
	public function singleViewNotDisplaysTheEquipmentDescriptionOfARealtyObjectIfDisabled() {
		$realtyObject = tx_oelib_MapperRegistry::get('tx_realty_Mapper_RealtyObject')
			->getLoadedTestingModel(array('equipment' => 'foo'));

		$this->fixture->setConfigurationValue(
			'singleViewPartsToDisplay', 'heading'
		);

		$this->assertNotContains(
			'foo',
			$this->fixture->render(array('showUid' => $realtyObject->getUid()))
		);
	}

	/**
	 * @test
	 */
	public function singleViewDisplaysTheAddToFavoritesButtonIfEnabled() {
		$realtyObject = tx_oelib_MapperRegistry::get('tx_realty_Mapper_RealtyObject')
			->getLoadedTestingModel(array('title' => 'foo'));

		$this->fixture->setConfigurationValue(
			'singleViewPartsToDisplay', 'addToFavoritesButton'
		);

		$this->assertContains(
			'class="button singleViewAddToFavorites"',
			$this->fixture->render(array('showUid' => $realtyObject->getUid()))
		);
	}

	/**
	 * @test
	 */
	public function singleViewNotDisplaysTheAddToFavoritesButtonIfDisabled() {
		$realtyObject = tx_oelib_MapperRegistry::get('tx_realty_Mapper_RealtyObject')
			->getLoadedTestingModel(array('title' => 'foo'));

		$this->fixture->setConfigurationValue(
			'singleViewPartsToDisplay', 'backButton'
		);

		$this->assertNotContains(
			'class="button singleViewAddToFavorites"',
			$this->fixture->render(array('showUid' => $realtyObject->getUid()))
		);
	}

	/**
	 * @test
	 */
	public function singleViewDisplaysThePrintPageButtonIfEnabled() {
		$realtyObject = tx_oelib_MapperRegistry::get('tx_realty_Mapper_RealtyObject')
			->getLoadedTestingModel(array('title' => 'foo'));

		$this->fixture->setConfigurationValue(
			'singleViewPartsToDisplay', 'printPageButton'
		);

		$this->assertContains(
			'class="button printPage"',
			$this->fixture->render(array('showUid' => $realtyObject->getUid()))
		);
	}

	/**
	 * @test
	 */
	public function singleViewNotDisplaysThePrintPageButtonIfDisabled() {
		$realtyObject = tx_oelib_MapperRegistry::get('tx_realty_Mapper_RealtyObject')
			->getLoadedTestingModel(array('title' => 'foo'));

		$this->fixture->setConfigurationValue(
			'singleViewPartsToDisplay', 'addToFavoritesButton'
		);

		$this->assertNotContains(
			'class="button printPage"',
			$this->fixture->render(array('showUid' => $realtyObject->getUid()))
		);
	}

	/**
	 * @test
	 */
	public function singleViewDisplaysTheBackButtonIfEnabled() {
		$realtyObject = tx_oelib_MapperRegistry::get('tx_realty_Mapper_RealtyObject')
			->getLoadedTestingModel(array('title' => 'foo'));

		$this->assertContains(
			'class="button singleViewBack"',
			$this->fixture->render(array('showUid' => $realtyObject->getUid()))
		);
	}

	/**
	 * @test
	 */
	public function singleViewNotDisplaysTheBackButtonIfDisabled() {
		$realtyObject = tx_oelib_MapperRegistry::get('tx_realty_Mapper_RealtyObject')
			->getLoadedTestingModel(array('title' => 'foo'));

		$this->fixture->setConfigurationValue(
			'singleViewPartsToDisplay', 'printPageButton'
		);

		$this->assertNotContains(
			'class="button singleViewBack"',
			$this->fixture->render(array('showUid' => $realtyObject->getUid()))
		);
	}

	/**
	 * @test
	 */
	public function singleViewNotDisplayingAnyOfTheActionButtonsHidesActionSubpart() {
		$realtyObject = tx_oelib_MapperRegistry::get('tx_realty_Mapper_RealtyObject')
			->getLoadedTestingModel(array('title' => 'foo'));

		$this->fixture->setConfigurationValue(
			'singleViewPartsToDisplay', 'header'
		);
		$this->fixture->render(array('showUid' => $realtyObject->getUid()));

		$this->assertFalse(
			$this->fixture->isSubpartVisible('FIELD_WRAPPER_ACTIONBUTTONS')
		);
	}

	/**
	 * @test
	 */
	public function singleViewNotDisplaysTextPaneDivIfOnlyImagesShouldBeDisplayed() {
		$realtyObject = tx_oelib_MapperRegistry::get('tx_realty_Mapper_RealtyObject')
			->getLoadedTestingModel(array('title' => 'foo'));

		$this->fixture->setConfigurationValue(
			'singleViewPartsToDisplay', 'imageThumbnails'
		);

		$this->assertNotContains(
			'<div class="text-pane',
			$this->fixture->render(array('showUid' => $realtyObject->getUid()))
		);
	}

	/**
	 * @test
	 */
	public function singleViewDisplaysTextPaneDivAndWithImagesClassNameImagesAndTextShouldBeDisplayed() {
		$realtyObject = tx_oelib_MapperRegistry::get('tx_realty_Mapper_RealtyObject')
			->getLoadedTestingModel(array('title' => 'foo'));

		$this->fixture->setConfigurationValue(
			'singleViewPartsToDisplay', 'heading,imageThumbnails'
		);

		$this->assertContains(
			'<div class="text-pane with-images',
			$this->fixture->render(array('showUid' => $realtyObject->getUid()))
		);
	}

	/**
	 * @test
	 */
	public function singleViewNotDisplaysWithImagesClassNameIfOnlyTextShouldBeDisplayed() {
		$realtyObject = tx_oelib_MapperRegistry::get('tx_realty_Mapper_RealtyObject')
			->getLoadedTestingModel(array('title' => 'foo'));

		$this->fixture->setConfigurationValue(
			'singleViewPartsToDisplay', 'heading'
		);

		$this->assertNotContains(
			'with-images',
			$this->fixture->render(array('showUid' => $realtyObject->getUid()))
		);
	}


	/**
	 * @test
	 */
	public function singleViewDisplaysContactButtonIfThisIsEnabled() {
		$realtyObject = tx_oelib_MapperRegistry::get('tx_realty_Mapper_RealtyObject')
			->getLoadedTestingModel(array('title' => 'test title'));

		$this->fixture->setConfigurationValue(
			'contactPID', $this->testingFramework->createFrontEndPage()
		);

		$this->assertContains(
			'class="button singleViewContact"',
			$this->fixture->render(array('showUid' => $realtyObject->getUid()))
		);
	}

	/**
	 * @test
	 */
	public function singleViewNotDisplaysContactButtonIfThisIsDisabled() {
		$realtyObject = tx_oelib_MapperRegistry::get('tx_realty_Mapper_RealtyObject')
			->getLoadedTestingModel(array('title' => 'test title'));

		$this->fixture->setConfigurationValue(
			'singleViewPartsToDisplay', 'heading'
		);
		$this->fixture->setConfigurationValue(
			'contactPID', $this->testingFramework->createFrontEndPage()
		);

		$this->assertNotContains(
			'class="button singleViewContact"',
			$this->fixture->render(array('showUid' => $realtyObject->getUid()))
		);
	}

	/**
	 * @test
	 */
	public function singleViewDisplaysOffererInformationIfThisIsEnabled() {
		$realtyObject = tx_oelib_MapperRegistry::get('tx_realty_Mapper_RealtyObject')
			->getLoadedTestingModel(array('phone_switchboard' => '12345'));

		$this->fixture->setConfigurationValue(
			'singleViewPartsToDisplay', 'offerer'
		);
		$this->fixture->setConfigurationValue(
			'displayedContactInformation', 'telephone'
		);

		$this->assertContains(
			$this->fixture->translate('label_offerer'),
			$this->fixture->render(array('showUid' => $realtyObject->getUid()))
		);
	}

	/**
	 * @test
	 */
	public function singleViewDisplaysOffererInformationIfThisIsDisabled() {
		$realtyObject = tx_oelib_MapperRegistry::get('tx_realty_Mapper_RealtyObject')
			->getLoadedTestingModel(array('phone_switchboard' => '12345'));

		$this->fixture->setConfigurationValue(
			'singleViewPartsToDisplay', 'heading'
		);
		$this->fixture->setConfigurationValue(
			'displayedContactInformation', 'telephone'
		);

		$this->assertNotContains(
			$this->fixture->translate('label_offerer'),
			$this->fixture->render(array('showUid' => $realtyObject->getUid()))
		);
	}

	/**
	 * @test
	 */
	public function singleViewDisplaysStatusIfThisIsEnabled() {
		$realtyObject = tx_oelib_MapperRegistry::get('tx_realty_Mapper_RealtyObject')
			->getLoadedTestingModel(array());

		$this->fixture->setConfigurationValue(
			'singleViewPartsToDisplay', 'status'
		);

		$this->assertContains(
			'tx-realty-pi1-status',
			$this->fixture->render(array('showUid' => $realtyObject->getUid()))
		);
	}

	/**
	 * @test
	 */
	public function singleViewNotDisplaysStatusIfThisIsDisabled() {
		$realtyObject = tx_oelib_MapperRegistry::get('tx_realty_Mapper_RealtyObject')
			->getLoadedTestingModel(array());

		$this->fixture->setConfigurationValue(
			'singleViewPartsToDisplay', 'heading'
		);

		$this->assertNotContains(
			'tx-realty-pi1-status',
			$this->fixture->render(array('showUid' => $realtyObject->getUid()))
		);
	}

	/**
	 * @test
	 */
	public function singleViewDisplaysOverviewTableRowIfEnabled() {
		$realtyObject = tx_oelib_MapperRegistry::get('tx_realty_Mapper_RealtyObject')
			->getLoadedTestingModel(array('has_air_conditioning' => '1'));

		$this->fixture->setConfigurationValue(
			'singleViewPartsToDisplay', 'overviewTable'
		);
		$this->fixture->setConfigurationValue(
			'fieldsInSingleViewTable', 'has_air_conditioning'
		);

		$this->assertContains(
			$this->fixture->translate('label_has_air_conditioning'),
			$this->fixture->render(array('showUid' => $realtyObject->getUid()))
		);
	}

	/**
	 * @test
	 */
	public function singleViewNotDisplaysOverviewTableRowIfDisabled() {
		$realtyObject = tx_oelib_MapperRegistry::get('tx_realty_Mapper_RealtyObject')
			->getLoadedTestingModel(array('has_air_conditioning' => '1'));

		$this->fixture->setConfigurationValue(
			'singleViewPartsToDisplay', 'heading'
		);
		$this->fixture->setConfigurationValue(
			'fieldsInSingleViewTable', 'has_air_conditioning'
		);

		$this->assertNotContains(
			$this->fixture->translate('label_has_air_conditioning'),
			$this->fixture->render(array('showUid' => $realtyObject->getUid()))
		);
	}

	/**
	 * @test
	 */
	public function singleViewDisplaysTheAddressOfARealtyObjectIfEnabled() {
		$realtyObject = tx_oelib_MapperRegistry::get('tx_realty_Mapper_RealtyObject')
			->getLoadedTestingModel(array('zip' => '12345'));

		$this->fixture->setConfigurationValue(
			'singleViewPartsToDisplay', 'address'
		);

		$this->assertContains(
			'12345',
			$this->fixture->render(array('showUid' => $realtyObject->getUid()))
		);
	}

	/**
	 * @test
	 */
	public function singleViewNotDisplaysTheAddressOfARealtyObjectIfDisabled() {
		$realtyObject = tx_oelib_MapperRegistry::get('tx_realty_Mapper_RealtyObject')
			->getLoadedTestingModel(array('zip' => '12345'));

		$this->fixture->setConfigurationValue(
			'singleViewPartsToDisplay', 'heading'
		);

		$this->assertNotContains(
			'12345',
			$this->fixture->render(array('showUid' => $realtyObject->getUid()))
		);
	}


	/////////////////////////////////////////////
	// Tests for Google Maps in the single view
	/////////////////////////////////////////////

	/**
	 * @test
	 */
	public function singleViewDisplaysMapForGoogleMapsEnabled() {
		$realtyObject = tx_oelib_MapperRegistry::get('tx_realty_Mapper_RealtyObject')
			->getLoadedTestingModel(array(
				'has_coordinates' => TRUE,
				'latitude' => 50.734343,
				'longitude' => 7.10211,
				'show_address' => TRUE,
		));
		$this->fixture->setConfigurationValue(
			'singleViewPartsToDisplay', 'googleMaps'
		);

		$this->assertContains(
			'<div id="tx_realty_map"',
			$this->fixture->render(array('showUid' => $realtyObject->getUid()))
		);
	}

	/**
	 * @test
	 */
	public function singleViewNotDisplaysMapForGoogleMapsDisabled() {
		$realtyObject = tx_oelib_MapperRegistry::get('tx_realty_Mapper_RealtyObject')
			->getLoadedTestingModel(array(
				'has_coordinates' => TRUE,
				'latitude' => 50.734343,
				'longitude' => 7.10211,
				'show_address' => TRUE,
		));

		$this->fixture->setConfigurationValue(
			'singleViewPartsToDisplay', 'heading'
		);

		$this->assertNotContains(
			'<div id="tx_realty_map"',
			$this->fixture->render(array('showUid' => $realtyObject->getUid()))
		);
	}

	/**
	 * @test
	 */
	public function googleMapsDoesNotLinkObjectTitleInMap() {
		$realtyObject = tx_oelib_MapperRegistry::get('tx_realty_Mapper_RealtyObject')
			->getLoadedTestingModel(array(
				'has_coordinates' => TRUE,
				'latitude' => 50.734343,
				'longitude' => 7.10211,
				'show_address' => TRUE,
		));

		$this->fixture->setConfigurationValue(
			'singleViewPartsToDisplay', 'googleMaps'
		);

		$this->fixture->render(array('showUid' => $realtyObject->getUid()));
		$this->assertNotContains(
			'href=',
			$GLOBALS['TSFE']->additionalHeaderData['tx_realty_pi1_maps']
		);
	}

	/**
	 * @test
	 */
	public function singleViewForActivatedListViewGoogleMapsDoesNotShowGoogleMapsByDefault() {
		$realtyObject = tx_oelib_MapperRegistry::get('tx_realty_Mapper_RealtyObject')
			->getLoadedTestingModel(array(
				'has_coordinates' => TRUE,
				'latitude' => 50.734343,
				'longitude' => 7.10211,
				'show_address' => TRUE,
		));

		$this->fixture->setConfigurationValue('showGoogleMaps', 1);

		$this->assertNotContains(
			'<div id="tx_realty_map"',
			$this->fixture->render(array('showUid' => $realtyObject->getUid()))
		);
	}


	///////////////////////////////////////////////////
	// Tests concerning the next and previous buttons
	///////////////////////////////////////////////////

	/**
	 * @test
	 */
	public function singleViewForEnabledNextPreviousButtonsShowsNextPreviousButtonsSubpart() {
		$objectUid = $this->testingFramework->createRecord(
			'tx_realty_objects', array('city' => $this->dummyCityUid)
		);
		$this->testingFramework->createRecord(
			'tx_realty_objects', array('city' => $this->dummyCityUid)
		);
		$GLOBALS['TSFE']->cObj->data['pid'] = $this->testingFramework->createFrontEndPage();

		$this->fixture->setConfigurationValue(
			'enableNextPreviousButtons', TRUE
		);
		$this->fixture->setConfigurationValue(
			'singleViewPartsToDisplay', 'nextPreviousButtons'
		);

		$this->assertContains(
			'previousNextButtons',
			$this->fixture->render(array(
				'showUid' => $objectUid,
				'recordPosition' => 0,
				'listViewType' => 'realty_list',
				'listUid' => $this->testingFramework->createContentElement(),
			))
		);
	}

	/**
	 * @test
	 */
	public function singleViewForEnabledNextPreviousButtonsButNotSetDisplayPartHidesNextPreviousButtonsSubpart() {
		$objectUid = $this->testingFramework->createRecord(
			'tx_realty_objects', array('city' => $this->dummyCityUid)
		);
		$GLOBALS['TSFE']->cObj->data['pid'] = $this->testingFramework->createFrontEndPage();

		$this->fixture->setConfigurationValue(
			'enableNextPreviousButtons', TRUE
		);
		$this->fixture->setConfigurationValue(
			'singleViewPartsToDisplay', ''
		);

		$this->assertNotContains(
			'previousNextButtons',
			$this->fixture->render(array(
				'showUid' => $objectUid,
				'recordPosition' => 0,
				'listViewType' => 'realty_list',
				'listUid' => $this->testingFramework->createContentElement(),
			))
		);
	}

	/**
	 * @test
	 */
	public function singleViewForDisabledNextPreviousButtonsHidesNextPreviousButtonsSubpart() {
		$objectUid = $this->testingFramework->createRecord(
			'tx_realty_objects', array('city' => $this->dummyCityUid)
		);
		$GLOBALS['TSFE']->cObj->data['pid'] = $this->testingFramework->createFrontEndPage();

		$this->fixture->setConfigurationValue(
			'enableNextPreviousButtons', FALSE
		);
		$this->fixture->setConfigurationValue(
			'singleViewPartsToDisplay', 'nextPreviousButtons'
		);

		$this->assertNotContains(
			'previousNextButtons',
			$this->fixture->render(array(
				'showUid' => $objectUid,
				'recordPosition' => 0,
				'listViewType' => 'realty_list',
			))
		);
	}
}