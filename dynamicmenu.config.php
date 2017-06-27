<?php
/**********************************
 | Dynamic Menu configuration
 |
 **********************************/



//------- SETTINGS ---------------------------------------------//
# RESEARCHER
$dozent = $wissenschaftler = 'Researcher';
$email = 'researcher&lt;at&gt;ciry.at';
$tel = '+49 (0)000 -[no phone]';
$fax = '+49 (0)000 -[no fax]';

# PAGE
$ownSheets = array('css/additionalclasses.css','../fairyclasses.css');
$ownScripts = array('js/func.js');
$charset = 'utf-8'; #'iso-8859-1';

# START PAGE
$startEN = 'index.php'; // HACK: If home is a directory, then home/index.php is loaded and the check then is index in startPages in DynamicMenu.class.php
$startDE = 'index.php';

# YOUR ORGANIZATION
$lehrstuhl = 'Lehrstuhl II';
$lehrstuhlHomepage = 'http://www2.mathematik.uni-wuerzburg.de/';
$chair = 'Chair II';
$chairHomepage = 'http://www2.mathematik.uni-wuerzburg.de/?lang=en';





// MENU -----------
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
// Not related files from /var/www (because ciry.at points to this root directory for short file reference)
,'0ad'
,'Anuschka'
,'Babyglueck'
,'Bewerbung_Kaserne_Altenstadt.odt'
,'Bewerbung_Polizei_Ostallgaeu.odt'
,'Blog.class.php'
,'Brice'
,'Castle'
,'CattleTool'
,'Chat'
,'Design'
,'DrawDepartment.class.php'
,'DynMenu.class.php'
,'DynamicMenu.class.php'
,'Eragon'
,'FileShark'
,'HiWi'
,'HowTo'
,'Img'
,'Installer'
,'Jean'
,'LUMIX-Videos'
,'Libellenflug'
,'Lord'
,'Modellbau'
,'NMLab'
,'Page.class.php'
,'Savoniuswindcalculator7.ods'
,'Savoniuswindcalculator7_Electrodus_ext_Radagast.ods'
,'SevenHorses'
,'Sokrates'
,'Tanoth'
,'Tools'
,'Uni'
,'Unibert'
,'User.class.php'
,'_IMAGEFORMAT_sets_height.html'
,'_UNSERE_BUCHLINSE-bookmicroscope.html'
,'ai-client-html'
,'ai-typo3'
,'ai-vat'
,'aimeos-core'
,'aimeos-typo3'
,'aimeos__16_3_1'
,'aimeos__16_4_3'
,'aimeos__17_4_'
,'aimeos__17_4_1'
,'aimeos_hamag'
,'aimeos_hamag.bak'
,'aimeos_quadzz'
,'aimeos_setup_backup_language_default_set.bak'
,'angelika_hirschberg'
,'angelika_hirschberg_site'
,'angelika_hirschberg_t3template'
,'aqi8'
,'aqi8t3'
,'astronomy'
,'atmosphere_man.jpg'
,'aufgaben_db.war'
,'blue_eye'
,'cgi-bin'
,'dynamic_site'
,'dynamicmenu.config.php'
,'fairyclasses.css'
,'fairydrag.class.js'
,'fairytale.js'
,'fileshark.cfg.php'
,'filter.js'
,'fitness_stall'
,'fitness_stall.git'
,'fonts'
,'functions.inc.php'
,'functions2.inc.php'
,'functions2i.inc.php'
,'hamag'
,'hamag_maschinenbau'
,'hg'
,'html'
,'images'
,'img'
,'index.html'
,'js'
,'kurse'
,'lib.debug.php'
,'lohtax'
,'mediacolumn.css'
,'middleearth'
,'mods'
,'music'
,'music.git'
,'opensourceecology'
,'owl_man.jpg'
,'present'
,'quadz__aimeos_16_4_3__2016_08_04.sql'
,'quadzz'
,'riddly'
,'robots.txt'
,'shell__aimeos_release_script'
,'tags.inc.php'
,'tools'
,'typo3_src-7.5.0'
,'typo3_src-7.6.10'
,'typo3_src-8.7.0'
,'uni'
,'worlddevelopment'
);


# ELEMENTS on/off  --//to disable set to FALSE:
$impressum = true;
$quicknav = true;
$quicklinks = false;
$ownquicklinks = false;
$ownquickhtml = '<ul class="a_class">'  // Simply copy next line:
		.'<li>'/*.extlink('example', 'http://example.ip/', false, true)*/.'</li>'
		.'</ul>';


#DYNAMIC MENU
$recursive  = true;
$shortIDs   = true;
$end = false;
$notEnd = array('js', 'css');
$endMode = 'l';
$path = './';
$type = 'allget'; # {all|files|dir}get <=> what to phpInclude


# DYNAMIC MENU SETTINGS
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


# FOOTER HTML
$footer = true;
$footerText = 'Dynamic Menu';
$footerUrl = 'http://ciry.at/HiWi/seashark/?id=dynamic_menu';
$footerClasses = '';
$dynMenuContact = 'contact i@ciry.at for Dynamic Menu';
$footerHTML = '<a href="'.$footerUrl.'" class="'.$footerClasses.'"'
			  .' title="'.$dynMenuContact.'">'.$footerText.'</a>';















/*
MODIFY WITH CAUTION if non-default behaviour is desired.
Uncomment if desired (remove '#' or '//' at line start.
*/
$title = $wissenschaftler;
#$title = '<custom title>';

#$impressumUrl = '?id=impressum.html';  # Is already the default.
// impressum.html exists in both English(en-), German(de-folder).


//SET START IF ONLY ONE IS SET
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





//------- VALIDATION-TESTs ------------------------------------//

if (!is_bool($impressum)) {
	$impressum = false;  #only {true|false} is possible
}







?>

