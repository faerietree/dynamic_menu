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
'0ad'
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
,'Archive'
,'archive'
,'body.tpl'
,'bottom.tpl'
,'cgi-bin'
,'cloudy'
,'db.inc.php'
,'dynamicmenu.config'
,'dynamicmenu.cfg'
,'DynamicMenu.class'
,'dynamic_menu'
,'dynamic_site'
,'DynamicMenu.class'
,'Endor'
,'error'
,'error404'
,'FairyTale'
,'fileadmin'
,'files'
,'fitness_stall'
,'fitness_stall.git'
,'fonts'
,'footer'
,'foot.tpl'
,'gallery-css'
,'hamag'
,'hamag_site'
,'hamag_t3'
,'hamag_t3template'
,'images'
,'Img'
,'img'
,'impressum'
,'index'
,'LICENSE'
,'logs'
,'lohtax'
,'lohtax_t3template'
,'media'
,'music.git'
,'quadzz'
,'README'
,'robots'
,'sonstiges'
,'other_information'
,'pepper'
,'present'
,'SevenHorses'
,'SevenMagics'
,'top.tpl'
,'treasury'
,'uploads'
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
$radius = 23;
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


?>
