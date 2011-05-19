<?php

########################################################################
# Extension Manager/Repository config file for ext "realty".
#
# Auto generated 13-09-2010 19:09
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Realty Manager',
	'description' => 'This extension provides a plugin that displays realty objects (immovables, properties, real estate), including an image gallery for each object.',
	'category' => 'plugin',
	'author' => 'Oliver Klee',
	'author_email' => 'typo3-coding@oliverklee.de',
	'shy' => 0,
	'dependencies' => 'css_styled_content,oelib,ameos_formidable,static_info_tables',
	'conflicts' => 'dbal',
	'priority' => '',
	'module' => 'BackEnd',
	'state' => 'stable',
	'internal' => '',
	'uploadfolder' => 1,
	'createDirs' => 'uploads/tx_realty/rte/',
	'modify_tables' => 'fe_users',
	'clearCacheOnLoad' => 1,
	'lockType' => '',
	'author_company' => '',
	'version' => '0.5.63',
	'_md5_values_when_last_written' => 'a:224:{s:9:"ChangeLog";s:4:"ac14";s:20:"class.ext_update.php";s:4:"b156";s:23:"class.tx_realty_Tca.php";s:4:"0749";s:31:"class.tx_realty_configcheck.php";s:4:"48f8";s:16:"ext_autoload.php";s:4:"8464";s:21:"ext_conf_template.txt";s:4:"578d";s:12:"ext_icon.gif";s:4:"f073";s:17:"ext_localconf.php";s:4:"1e6a";s:14:"ext_tables.php";s:4:"18c1";s:14:"ext_tables.sql";s:4:"1a47";s:13:"locallang.xml";s:4:"69a8";s:16:"locallang_db.xml";s:4:"5844";s:7:"tca.php";s:4:"0f1d";s:8:"todo.txt";s:4:"7f11";s:46:"Ajax/class.tx_realty_Ajax_DistrictSelector.php";s:4:"fd6f";s:34:"Ajax/tx_realty_Ajax_Dispatcher.php";s:4:"1b62";s:19:"BackEnd/BackEnd.css";s:4:"6175";s:42:"BackEnd/class.tx_realty_BackEnd_Module.php";s:4:"9c0d";s:17:"BackEnd/clear.gif";s:4:"cc11";s:16:"BackEnd/conf.php";s:4:"7541";s:17:"BackEnd/index.php";s:4:"c4df";s:21:"BackEnd/locallang.xml";s:4:"e94c";s:25:"BackEnd/locallang_mod.xml";s:4:"8a19";s:25:"BackEnd/mod_template.html";s:4:"3162";s:22:"BackEnd/moduleicon.gif";s:4:"f073";s:19:"Mapper/Document.php";s:4:"e33b";s:16:"Mapper/Image.php";s:4:"8e30";s:38:"Mapper/class.tx_realty_Mapper_City.php";s:4:"1fcc";s:42:"Mapper/class.tx_realty_Mapper_District.php";s:4:"4635";s:46:"Mapper/class.tx_realty_Mapper_FrontEndUser.php";s:4:"4d96";s:46:"Mapper/class.tx_realty_Mapper_RealtyObject.php";s:4:"72e5";s:18:"Model/Document.php";s:4:"56a1";s:15:"Model/Image.php";s:4:"63ab";s:36:"Model/class.tx_realty_Model_City.php";s:4:"2df1";s:40:"Model/class.tx_realty_Model_District.php";s:4:"dbd2";s:44:"Model/class.tx_realty_Model_FrontEndUser.php";s:4:"554e";s:44:"Model/class.tx_realty_Model_RealtyObject.php";s:4:"371a";s:30:"Resources/Public/Icons/Pdf.png";s:4:"2021";s:27:"cli/class.tx_realty_cli.php";s:4:"8449";s:40:"cli/class.tx_realty_cli_ImageCleanUp.php";s:4:"438c";s:47:"cli/class.tx_realty_cli_ImageCleanUpStarter.php";s:4:"fa46";s:14:"doc/manual.sxw";s:4:"070d";s:40:"icons/icon_tx_realty_apartment_types.gif";s:4:"d517";s:35:"icons/icon_tx_realty_car_places.gif";s:4:"bb75";s:31:"icons/icon_tx_realty_cities.gif";s:4:"bfc0";s:34:"icons/icon_tx_realty_districts.gif";s:4:"5fc7";s:34:"icons/icon_tx_realty_documents.gif";s:4:"a771";s:36:"icons/icon_tx_realty_house_types.gif";s:4:"e878";s:31:"icons/icon_tx_realty_images.gif";s:4:"e1a6";s:34:"icons/icon_tx_realty_images__h.gif";s:4:"a067";s:30:"icons/icon_tx_realty_items.gif";s:4:"475a";s:32:"icons/icon_tx_realty_objects.gif";s:4:"f073";s:35:"icons/icon_tx_realty_objects__h.gif";s:4:"a523";s:29:"icons/icon_tx_realty_pets.gif";s:4:"57cd";s:36:"lib/class.tx_realty_cacheManager.php";s:4:"83cf";s:44:"lib/class.tx_realty_domDocumentConverter.php";s:4:"c6fc";s:38:"lib/class.tx_realty_fileNameMapper.php";s:4:"8136";s:40:"lib/class.tx_realty_googleMapsLookup.php";s:4:"4683";s:40:"lib/class.tx_realty_lightboxIncluder.php";s:4:"5c13";s:33:"lib/class.tx_realty_mapMarker.php";s:4:"63f9";s:38:"lib/class.tx_realty_openImmoImport.php";s:4:"27ed";s:34:"lib/class.tx_realty_translator.php";s:4:"c560";s:17:"lib/locallang.xml";s:4:"1704";s:27:"lib/tx_realty_constants.php";s:4:"cb8c";s:36:"lib/tx_realty_emailNotification.tmpl";s:4:"c378";s:21:"pi1/DocumentsView.php";s:4:"842b";s:18:"pi1/StatusView.php";s:4:"c2e9";s:14:"pi1/ce_wiz.gif";s:4:"fe10";s:35:"pi1/class.tx_realty_contactForm.php";s:4:"3b88";s:34:"pi1/class.tx_realty_filterForm.php";s:4:"7cf1";s:38:"pi1/class.tx_realty_frontEndEditor.php";s:4:"7b8e";s:36:"pi1/class.tx_realty_frontEndForm.php";s:4:"b561";s:43:"pi1/class.tx_realty_frontEndImageUpload.php";s:4:"a729";s:35:"pi1/class.tx_realty_offererList.php";s:4:"ce6e";s:27:"pi1/class.tx_realty_pi1.php";s:4:"32ce";s:44:"pi1/class.tx_realty_pi1_AbstractListView.php";s:4:"5bb2";s:39:"pi1/class.tx_realty_pi1_AccessCheck.php";s:4:"101f";s:52:"pi1/class.tx_realty_pi1_AddToFavoritesButtonView.php";s:4:"4ca6";s:39:"pi1/class.tx_realty_pi1_AddressView.php";s:4:"7176";s:42:"pi1/class.tx_realty_pi1_BackButtonView.php";s:4:"2548";s:45:"pi1/class.tx_realty_pi1_ContactButtonView.php";s:4:"b526";s:43:"pi1/class.tx_realty_pi1_DefaultListView.php";s:4:"a989";s:43:"pi1/class.tx_realty_pi1_DescriptionView.php";s:4:"cb80";s:37:"pi1/class.tx_realty_pi1_ErrorView.php";s:4:"2fd2";s:45:"pi1/class.tx_realty_pi1_FavoritesListView.php";s:4:"6d16";s:37:"pi1/class.tx_realty_pi1_Formatter.php";s:4:"2af0";s:40:"pi1/class.tx_realty_pi1_FrontEndView.php";s:4:"1645";s:50:"pi1/class.tx_realty_pi1_FurtherDescriptionView.php";s:4:"aa20";s:42:"pi1/class.tx_realty_pi1_GoogleMapsView.php";s:4:"68cc";s:39:"pi1/class.tx_realty_pi1_HeadingView.php";s:4:"840a";s:47:"pi1/class.tx_realty_pi1_ImageThumbnailsView.php";s:4:"d877";s:43:"pi1/class.tx_realty_pi1_ListViewFactory.php";s:4:"8205";s:45:"pi1/class.tx_realty_pi1_MyObjectsListView.php";s:4:"3315";s:51:"pi1/class.tx_realty_pi1_NextPreviousButtonsView.php";s:4:"46c4";s:50:"pi1/class.tx_realty_pi1_ObjectsByOwnerListView.php";s:4:"d9c8";s:39:"pi1/class.tx_realty_pi1_OffererView.php";s:4:"2106";s:45:"pi1/class.tx_realty_pi1_OverviewTableView.php";s:4:"55b4";s:37:"pi1/class.tx_realty_pi1_PriceView.php";s:4:"b3a7";s:47:"pi1/class.tx_realty_pi1_PrintPageButtonView.php";s:4:"89eb";s:38:"pi1/class.tx_realty_pi1_SingleView.php";s:4:"1321";s:35:"pi1/class.tx_realty_pi1_wizicon.php";s:4:"9a26";s:23:"pi1/flexform_pi1_ds.xml";s:4:"dac9";s:17:"pi1/locallang.xml";s:4:"01d7";s:17:"pi1/submit_bg.gif";s:4:"9359";s:33:"pi1/tx_realty_frontEndEditor.html";s:4:"9ab6";s:32:"pi1/tx_realty_frontEndEditor.xml";s:4:"ef4c";s:37:"pi1/tx_realty_frontEndImageUpload.xml";s:4:"fbb4";s:20:"pi1/tx_realty_pi1.js";s:4:"0c54";s:25:"pi1/tx_realty_pi1.tpl.css";s:4:"8745";s:25:"pi1/tx_realty_pi1.tpl.htm";s:4:"ea79";s:27:"pi1/tx_realty_pi1_print.css";s:4:"3a05";s:28:"pi1/tx_realty_pi1_screen.css";s:4:"c4f6";s:22:"pi1/contrib/builder.js";s:4:"39e8";s:22:"pi1/contrib/effects.js";s:4:"327b";s:24:"pi1/contrib/lightbox.css";s:4:"a0fa";s:23:"pi1/contrib/lightbox.js";s:4:"5e8a";s:24:"pi1/contrib/prototype.js";s:4:"e5ff";s:28:"pi1/contrib/scriptaculous.js";s:4:"c189";s:33:"pi1/images/button_act_bg_left.png";s:4:"576e";s:34:"pi1/images/button_act_bg_right.png";s:4:"b2d7";s:29:"pi1/images/button_bg_left.png";s:4:"43d8";s:30:"pi1/images/button_bg_right.png";s:4:"63f6";s:30:"pi1/images/cityselector_bg.png";s:4:"11bc";s:32:"pi1/images/cityselector_head.png";s:4:"4106";s:25:"pi1/images/closelabel.gif";s:4:"f34a";s:24:"pi1/images/fav_arrow.png";s:4:"de5e";s:25:"pi1/images/fav_button.png";s:4:"91ae";s:22:"pi1/images/loading.gif";s:4:"7e99";s:24:"pi1/images/nextlabel.gif";s:4:"b25c";s:23:"pi1/images/page_act.png";s:4:"02fe";s:22:"pi1/images/page_no.png";s:4:"a172";s:24:"pi1/images/prevlabel.gif";s:4:"0f43";s:28:"pi1/images/search_button.png";s:4:"0f4c";s:26:"pi1/images/sort_button.png";s:4:"e6b0";s:28:"pi1/images/submit_button.png";s:4:"97e3";s:38:"pi1/images/submit_button_fe_editor.png";s:4:"4859";s:37:"pi1/images/submit_button_inactive.png";s:4:"d2e2";s:24:"pi1/static/constants.txt";s:4:"1928";s:20:"pi1/static/setup.txt";s:4:"bfb2";s:35:"tests/Ajax/DistrictSelectorTest.php";s:4:"5304";s:25:"tests/BackEnd/TcaTest.php";s:4:"552e";s:30:"tests/Cli/ImageCleanUpTest.php";s:4:"b0ba";s:39:"tests/FrontEnd/AbstractListViewTest.php";s:4:"39b9";s:35:"tests/FrontEnd/AbstractViewTest.php";s:4:"dae2";s:47:"tests/FrontEnd/AddToFavoritesButtonViewTest.php";s:4:"881a";s:34:"tests/FrontEnd/AddressViewTest.php";s:4:"d51e";s:37:"tests/FrontEnd/BackButtonViewTest.php";s:4:"6294";s:40:"tests/FrontEnd/ContactButtonViewTest.php";s:4:"cdfd";s:34:"tests/FrontEnd/ContactFormTest.php";s:4:"be18";s:40:"tests/FrontEnd/DefaultControllerTest.php";s:4:"b8ba";s:38:"tests/FrontEnd/DefaultListViewTest.php";s:4:"3d91";s:38:"tests/FrontEnd/DescriptionViewTest.php";s:4:"64f0";s:36:"tests/FrontEnd/DocumentsViewTest.php";s:4:"0d66";s:29:"tests/FrontEnd/EditorTest.php";s:4:"15d2";s:32:"tests/FrontEnd/ErrorViewTest.php";s:4:"326b";s:40:"tests/FrontEnd/FavoritesListViewTest.php";s:4:"dc81";s:33:"tests/FrontEnd/FilterFormTest.php";s:4:"ca5f";s:27:"tests/FrontEnd/FormTest.php";s:4:"597d";s:32:"tests/FrontEnd/FormatterTest.php";s:4:"5312";s:45:"tests/FrontEnd/FurtherDescriptionViewTest.php";s:4:"b14a";s:37:"tests/FrontEnd/GoogleMapsViewTest.php";s:4:"de12";s:34:"tests/FrontEnd/HeadingViewTest.php";s:4:"812f";s:42:"tests/FrontEnd/ImageThumbnailsViewTest.php";s:4:"ddc0";s:34:"tests/FrontEnd/ImageUploadTest.php";s:4:"2378";s:39:"tests/FrontEnd/LightboxIncluderTest.php";s:4:"0635";s:32:"tests/FrontEnd/MapMarkerTest.php";s:4:"143c";s:40:"tests/FrontEnd/MyObjectsListViewTest.php";s:4:"b093";s:46:"tests/FrontEnd/NextPreviousButtonsViewTest.php";s:4:"5488";s:45:"tests/FrontEnd/ObjectsByOwnerListViewTest.php";s:4:"a31a";s:34:"tests/FrontEnd/OffererListTest.php";s:4:"6a9a";s:34:"tests/FrontEnd/OffererViewTest.php";s:4:"bebe";s:40:"tests/FrontEnd/OverviewTableViewTest.php";s:4:"9d0f";s:32:"tests/FrontEnd/PriceViewTest.php";s:4:"2dc6";s:42:"tests/FrontEnd/PrintPageButtonViewTest.php";s:4:"10cb";s:33:"tests/FrontEnd/SingleViewTest.php";s:4:"9fa5";s:33:"tests/FrontEnd/StatusViewTest.php";s:4:"26d1";s:41:"tests/Import/DomDocumentConverterTest.php";s:4:"5237";s:35:"tests/Import/FileNameMapperTest.php";s:4:"6860";s:35:"tests/Import/OpenImmoImportTest.php";s:4:"e7bc";s:25:"tests/Mapper/CityTest.php";s:4:"20b8";s:29:"tests/Mapper/DistrictTest.php";s:4:"6376";s:29:"tests/Mapper/DocumentTest.php";s:4:"3ce6";s:33:"tests/Mapper/FrontEndUserTest.php";s:4:"b6b3";s:26:"tests/Mapper/ImageTest.php";s:4:"ea5f";s:33:"tests/Mapper/RealtyObjectTest.php";s:4:"95bf";s:24:"tests/Model/CityTest.php";s:4:"e8ed";s:28:"tests/Model/DistrictTest.php";s:4:"2d66";s:28:"tests/Model/DocumentTest.php";s:4:"fd59";s:32:"tests/Model/FrontEndUserTest.php";s:4:"1c7f";s:25:"tests/Model/ImageTest.php";s:4:"7011";s:32:"tests/Model/RealtyObjectTest.php";s:4:"c99e";s:33:"tests/Service/AccessCheckTest.php";s:4:"aa01";s:42:"tests/Service/FakeGoogleMapsLookupTest.php";s:4:"a2fb";s:38:"tests/Service/GoogleMapsLookupTest.php";s:4:"146e";s:37:"tests/Service/ListViewFactoryTest.php";s:4:"b36e";s:32:"tests/Service/TranslatorTest.php";s:4:"755f";s:58:"tests/fixtures/class.tx_realty_Model_RealtyObjectChild.php";s:4:"e27f";s:60:"tests/fixtures/class.tx_realty_domDocumentConverterChild.php";s:4:"97d4";s:54:"tests/fixtures/class.tx_realty_openImmoImportChild.php";s:4:"3d5f";s:70:"tests/fixtures/class.tx_realty_tests_fixtures_FakeGoogleMapsLookup.php";s:4:"05cb";s:65:"tests/fixtures/class.tx_realty_tests_fixtures_TestingListView.php";s:4:"9de9";s:69:"tests/fixtures/class.tx_realty_tests_fixtures_testingFrontEndView.php";s:4:"8c65";s:37:"tests/fixtures/listViewWithFloor.html";s:4:"182b";s:38:"tests/fixtures/listViewWithStatus.html";s:4:"5477";s:45:"tests/fixtures/tx_realty_fixtures/bar-bar.zip";s:4:"09cf";s:41:"tests/fixtures/tx_realty_fixtures/bar.zip";s:4:"b4ad";s:55:"tests/fixtures/tx_realty_fixtures/charset-ISO8859-1.zip";s:4:"7758";s:58:"tests/fixtures/tx_realty_fixtures/charset-UTF8-default.zip";s:4:"7fd6";s:50:"tests/fixtures/tx_realty_fixtures/charset-UTF8.zip";s:4:"cc72";s:53:"tests/fixtures/tx_realty_fixtures/contains-folder.zip";s:4:"7a6a";s:43:"tests/fixtures/tx_realty_fixtures/email.zip";s:4:"ac21";s:43:"tests/fixtures/tx_realty_fixtures/empty.zip";s:4:"6110";s:49:"tests/fixtures/tx_realty_fixtures/foo-deleted.zip";s:4:"e42c";s:52:"tests/fixtures/tx_realty_fixtures/foo-uppercased.zip";s:4:"222d";s:41:"tests/fixtures/tx_realty_fixtures/foo.zip";s:4:"d84c";s:41:"tests/fixtures/tx_realty_fixtures/pdf.zip";s:4:"e678";s:40:"tests/fixtures/tx_realty_fixtures/ps.zip";s:4:"b60f";s:47:"tests/fixtures/tx_realty_fixtures/same-name.zip";s:4:"7390";s:44:"tests/fixtures/tx_realty_fixtures/schema.xsd";s:4:"bf47";s:49:"tests/fixtures/tx_realty_fixtures/two-objects.zip";s:4:"4dba";s:49:"tests/fixtures/tx_realty_fixtures/valid-email.zip";s:4:"7cf0";s:66:"tests/fixtures/tx_realty_fixtures/with-email-and-openimmo-anid.zip";s:4:"d728";s:56:"tests/fixtures/tx_realty_fixtures/with-openimmo-anid.zip";s:4:"424c";s:73:"tests/fixtures/tx_realty_fixtures/changed-copy-of-same-name/same-name.zip";s:4:"6785";}',
	'constraints' => array(
		'depends' => array(
			'php' => '5.2.0-0.0.0',
			'typo3' => '4.3.0-0.0.0',
			'css_styled_content' => '',
			'oelib' => '0.7.60-',
			'ameos_formidable' => '1.1.0-1.9.99',
			'static_info_tables' => '2.1.0-',
		),
		'conflicts' => array(
			'dbal' => '',
		),
		'suggests' => array(
			'sr_feuser_register' => '',
		),
	),
	'suggests' => array(
		'sr_feuser_register' => '',
	),
);

?>