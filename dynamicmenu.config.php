<?php
/**********************************
 | Dynamic Menu configuration
 |
 **********************************/


# START PAGE
$startEN = 'index.php'; // HACK: If home is a directory, then home/index.php is loaded and the check then is index in startPages in DynamicMenu.class.php
$startDE = 'index.php';


# EXCEPTIONS
$e = array(
	'index.php',
	'db.inc.php',
	'fileshark.cfg.php',
	'dynamicmenu.config.php',
	'dynamicmenu.cfg.php',
	'Archive',
	'archive',
	'impressum.html',
	'sonstiges.html',
	'other_information.html',
	'FileShark.class.php',
	'DynamicMenu.class.php',
	'error.php',
	'error404.php',
	'body.tpl.php',
	'top.tpl.php',
	'bottom.tpl.php',
	'foot.tpl.php',
	'files',
	'images',
	'README',
	'README.md',
	'LICENSE',
	'LICENSE.txt'
);


$recursive  = true;
$shortIDs   = true;
$end = false;
$notEnd = array('js', 'css');
$endMode = 'l';
$path = './';
$type = 'allget'; # {all|files|dir}get <=> what to phpInclude
$circular = false;
$origin = ['50%', '50%'];
$radius = 33;
$unit = '%';

$evolved = true;
$orderBy = 'order';
$orderMode = 'asc';
$homeAlwaysAtTop = true;
$menuMap = array('Home', 'Seashark');  #Test
$translate = true;
// To get 1click-language-switch to work even with distinct file
//names per language: uncomment, map the corresponding files:
#$translate = array('en_file'=>'de_file','english'=>'englisch','german'=>'deutsch');


# STATIC MENU ENTRIES (e.g. http://<server>.<ending>)
//$staticEntries = array('static file'=>'./.hidden_file.ending');
if (isset($language) && $language == 'en') {
	//$staticEntries = array('static entry'=>'http://server.ip/');
}




/*
MODIFY WITH CAUTION if non-default behaviour is desired.
Uncomment if desired (remove '#' or '//' at line start.
*/
// One language start page suffices
$start = false;
if (!empty($startEN) && !$startDE) {
	$start = $startEN;
}
else if (!empty($startDE) && !$startEN) {
	$start = $startDE;
}



// Handle menu map and translate separately or not:
if (isset($menuMap)
&& (!isset($translate) || !empty($translate) || $translate === true)) {
	$translate = $menuMap;
}



?>
