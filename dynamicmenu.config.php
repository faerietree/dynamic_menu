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
	'dynamicmenu.config.php',
	'dynamicmenu.cfg.php',
	'Archive',
	'archive',
	'impressum.html',
	'sonstiges.html',
	'other_information.html',
	'DynamicMenu.class.php',
	'error.php',
	'error404.php',
	'body.tpl.php',
	'top.tpl.php',
	'bottom.tpl.php',
	'footer.php',
	'foot.tpl.php',
	'files',
	'images',
	'README',
	'README.md',
	'LICENSE',
	'LICENSE.txt'
	,'present'
// Not related files from root directory (where ciry.at points to for short file reference)
,'0ad'
,'cloudy'
,'pepper'
,'music.git'
,'fonts'
,'DynamicMenu.class.php'
,'Endor'
,'FairyTale'
,'Img'
,'SevenHorses'
,'SevenMagics'
,'ai-client-html'
,'ai-typo3'
,'ai-vat'
,'aimeos-core'
,'aimeos-typo3'
,'aimeos_17.7.2'
,'aimeos_quadzz'
,'angelika_hirschberg'
,'angelika_hirschberg_site'
,'angelika_hirschberg_t3template'
,'cgi-bin'
,'dynamic_menu'
,'dynamic_site'
,'dynamicmenu.config.php'
,'fitness_stall'
,'fitness_stall.git'
,'hamag'
,'hamag_site'
,'hamag_t3'
,'hamag_t3template'
,'img'
,'index.html'
,'lohtax'
,'lohtax_t3template'
,'quadzz'
,'robots.txt'
,'treasury'
,'web'
,'wp'
);


$recursive  = true;
$shortIDs   = true;
$end = false;
$notEnd = array('js', 'css');
$endMode = 'l';
$path = './';
$type = 'allget'; # {all|files|dir}get <=> what to phpInclude
$circular = true;
$origin = ['38%', '48%'];
$radius = 24;
$unit = '%';


$defaultLanguage = 'de';
$evolved = true;
$orderBy = 'order';
$orderMode = 'asc';
$homeAlwaysAtTop = true;
$translate = true;
// To get 1click-language-switch to work even with distinct file
// names per language: uncomment, map the corresponding files:
/*
$translate = array(
	'en_file'=>'de_file','english'=>'englisch','german'=>'deutsch'
);
*/


# STATIC MENU ENTRIES (e.g. http://<server>.<ending>)
$staticEntries = array(
	//'static file'=>'./.hidden_file.ending'
	//'shop'=>'https://shop.hamag-maschinenbau.de'
);
if (isset($language) && $language == 'en') {
	//$staticEntries = array('static entry'=>'http://server.ip/');
}






/*
MODIFY WITH CAUTION if non-default behaviour is desired.
Uncomment if desired (remove '#' or '//' at line start.
*/
// One language start page set suffices
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
