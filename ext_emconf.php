<?php

########################################################################
# Extension Manager/Repository config file for ext: "realty"
#
# Auto generated 30-01-2008 12:31
#
# Manual updates:
# Only the data in the array - anything else is removed by next write.
# "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Realty Manager',
	'description' => 'This extension provides a front-end plugin that displays realty objects/immovables (for sale as well as for renting), including a little image gallery for each object.',
	'category' => 'plugin',
	'author' => 'Oliver Klee',
	'author_email' => 'typo3-coding@oliverklee.de',
	'shy' => 0,
	'dependencies' => 'cms,oelib',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'beta',
	'internal' => '',
	'uploadfolder' => 1,
	'createDirs' => 'uploads/tx_realty/rte/',
	'modify_tables' => '',
	'clearCacheOnLoad' => 1,
	'lockType' => '',
	'author_company' => '',
	'version' => '0.1.99',
	'_md5_values_when_last_written' => 'a:54:{s:9:"ChangeLog";s:4:"6cb2";s:31:"class.tx_realty_configcheck.php";s:4:"603e";s:21:"ext_conf_template.txt";s:4:"5d5d";s:12:"ext_icon.gif";s:4:"f073";s:17:"ext_localconf.php";s:4:"3e1c";s:14:"ext_tables.php";s:4:"04a2";s:14:"ext_tables.sql";s:4:"0e71";s:13:"locallang.xml";s:4:"7f38";s:16:"locallang_db.xml";s:4:"c44b";s:7:"tca.php";s:4:"eeef";s:8:"todo.txt";s:4:"c7b3";s:40:"icons/icon_tx_realty_apartment_types.gif";s:4:"d517";s:35:"icons/icon_tx_realty_car_places.gif";s:4:"bb75";s:31:"icons/icon_tx_realty_cities.gif";s:4:"bfc0";s:35:"icons/icon_tx_realty_conditions.gif";s:4:"c6d7";s:34:"icons/icon_tx_realty_districts.gif";s:4:"5fc7";s:38:"icons/icon_tx_realty_heating_types.gif";s:4:"e16f";s:36:"icons/icon_tx_realty_house_types.gif";s:4:"e878";s:31:"icons/icon_tx_realty_images.gif";s:4:"e1a6";s:34:"icons/icon_tx_realty_images__h.gif";s:4:"a067";s:30:"icons/icon_tx_realty_items.gif";s:4:"475a";s:32:"icons/icon_tx_realty_objects.gif";s:4:"f073";s:35:"icons/icon_tx_realty_objects__h.gif";s:4:"a523";s:29:"icons/icon_tx_realty_pets.gif";s:4:"57cd";s:14:"doc/manual.sxw";s:4:"1450";s:30:"lib/class.tx_realty_object.php";s:4:"3799";s:35:"tests/tx_realty_object_testcase.php";s:4:"3795";s:32:"tests/tx_realty_pi1_testcase.php";s:4:"bd31";s:47:"tests/fixtures/class.tx_realty_object_child.php";s:4:"1704";s:14:"pi1/ce_wiz.gif";s:4:"fe10";s:27:"pi1/class.tx_realty_pi1.php";s:4:"40bd";s:35:"pi1/class.tx_realty_pi1_wizicon.php";s:4:"5af4";s:23:"pi1/flexform_pi1_ds.xml";s:4:"4245";s:17:"pi1/locallang.xml";s:4:"7a68";s:25:"pi1/tx_realty_pi1.tpl.css";s:4:"db70";s:25:"pi1/tx_realty_pi1.tpl.htm";s:4:"0faa";s:33:"pi1/images/button_act_bg_left.png";s:4:"576e";s:34:"pi1/images/button_act_bg_right.png";s:4:"b2d7";s:29:"pi1/images/button_bg_left.png";s:4:"43d8";s:30:"pi1/images/button_bg_right.png";s:4:"63f6";s:30:"pi1/images/cityselector_bg.png";s:4:"11bc";s:32:"pi1/images/cityselector_head.png";s:4:"4106";s:24:"pi1/images/fav_arrow.png";s:4:"de5e";s:25:"pi1/images/fav_button.png";s:4:"a879";s:21:"pi1/images/foto01.jpg";s:4:"3a80";s:21:"pi1/images/foto02.jpg";s:4:"6c18";s:21:"pi1/images/foto03.jpg";s:4:"80e6";s:23:"pi1/images/fullsize.jpg";s:4:"5ce0";s:23:"pi1/images/page_act.png";s:4:"02fe";s:22:"pi1/images/page_no.png";s:4:"a172";s:28:"pi1/images/search_button.png";s:4:"0f4c";s:26:"pi1/images/sort_button.png";s:4:"f8da";s:24:"pi1/static/editorcfg.txt";s:4:"7c17";s:20:"pi1/static/setup.txt";s:4:"5c6f";}',
	'constraints' => array(
		'depends' => array(
			'php' => '5.1.0-0.0.0',
			'typo3' => '4.1.2-0.0.0',
			'cms' => '',
			'oelib' => '0.3.99-',
		),
		'conflicts' => array(
		),
		'suggests' => array(
			'mailform_userfunc' => '0.0.3.-'
		),
	),
	'suggests' => array(
		'mailform_userfunc' => '0.0.3.-'
	),
);

?>