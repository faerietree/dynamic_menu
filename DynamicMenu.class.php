<!-- DynamicMenu -->
<?php
/*-------------------------------------*
 | DynamicMenu.class.php                 |
 | AutoMode enabled by default         |
 | Copyright (C) FairyTale Productions |
 *-------------------------------------*///---------------------------------//


// $auto to switch off bei include, because include() doesn't like parameters!!
// default actions  -- automatically executed if file is included - to deactivate manually
if (!isset($_GET['auto']) && !isset($auto) || ($_GET['auto'] != 'off' && $auto != 'off')) {
   $path_ = isset($_GET['home_dir']) ? $_GET['home_dir'] : './';  // set home_path
   $path_ = isset($_GET['path']) ? $_GET['path'] : $path_;        // set home_path -2nd
   $type_ = isset($_GET['type']) ? $_GET['type'] : 'dir';         // set type(all,files,..)
   $e_  = array('', '');
   if (isset($_GET['e']) && !is_array($_GET['e'])) {              // e is not an array !!
    $e_[]  = $_GET['e'];                                          // set addit exceptions
    $eLimit_ = isset($_GET['eLimit']) ? $_GET['eLimit'] : 3;      // set eLimit to other val
    for ($i = 0; $i < $eLimit; $i++) $e_[] = isset($_GET['e'.$i]) ? $_GET['e'.$i] : '';
   }
   else $e_ = isset($_GET['e']) ? $_GET['e'] : $e_;               // e is array => &e[]= !!
   $rec_ = isset($_GET['rec']) ? $_GET['rec'] : false;            // set recursive
   $rec_ = isset($_GET['r']) ? $_GET['r'] : $rec_;                // set recursive 2nd
   $rec_ = isset($_GET['recursive']) ? $_GET['recursive'] : $rec_;// set recursive 3rd
   $maxTiefe_ = isset($_GET['maxTiefe']) ? $_GET['maxTiefe'] : 2; // recursion depth limit
   $maxTiefe_ = isset($_GET['depth']) ? $_GET['depth'] : $maxTiefe_;

   $end_ = (isset($_GET['end'])) ? $_GET['end'] : false;          // Endungen
   $notEnd_ = (isset($_GET['notEnd'])) ? $_GET['notEnd'] : false; // keine erlaubten End.
   $endMode_ = (isset($_GET['endMode'])) ? $_GET['endMode'] : 'l';// z.B. letzten 2E pruefen
   $endMode_ = (isset($_GET['mode'])) ? $_GET['mode'] : $endMode_;// z.B. letzten 2E pruefen
   $base_ = (isset($_GET['b'])) ? $_GET['b'] : true;              //base dir pre or not
   $base_ = (isset($_GET['base'])) ? $_GET['base'] : $base_;      //base dir pre or not
   $evolved_ = isset($_GET['evolved']) ? $_GET['evolved'] : true; // whether evolved or not
   $orderedMenu_ = isset($_GET['orderedMenu']) ? $_GET['orderedMenu'] : true;#
   $orderBy_ = isset($_GET['orderBy']) ? $_GET['orderBy'] : false;// orderIndex or false
   $orderMode_ = isset($_GET['orderMode']) ? $_GET['orderMode'] : 'asc';
   $homeTop_ = isset($_GET['homeTop']) ? $_GET['homeTop'] : true; //whether always first
   $homeTop_ = isset($_GET['homeAlwaysAtTop']) ? $_GET['homeAlwaysAtTop'] : $homeTop_;
   $menuMap_ = isset($_GET['menuMap']) ? $_GET['menuMap'] : false;// own reorder
   $renderMenu_ = isset($_GET['renderMenu']) ? $_GET['renderMenu'] : true;#
                                                                  //without ending if poss
   $shortIDs_ = isset($_GET['shortIDs']) ? $_GET['shortIDs'] : true;//if set to true!!
   $shortIDs_ = isset($_GET['shortID']) ? $_GET['shortID'] : $shortIDs_;//but conflict if
   $shortIDs_ = isset($_GET['short']) ? $_GET['short'] : $shortIDs_;//dir == filename!!

   $statics_ = isset($_GET['statics']) ? $_GET['statics'] : array();//i.e.http://...
   $staticEntries_ = isset($_GET['staticEntries']) ? $_GET['staticEntries'] : $statics_;



   // variables set just before include -- falls nicht => $_GET -values  oder default
   $path = isset($path) ? $path : $path_;                         // set home_path -2nd
   $path = isset($home_dir) ? $home_dir : $path;                  // set home_path
   $type = isset($type) ? $type : $type_;                         // set type(all,files,..)
   if (isset($e) && !is_array($e)) {                              // e is not an array !!
    $e[]  = $e;                                                   // set addit exceptions
    $eLimit = isset($eLimit) ? $eLimit : $eLimit_;                // set eLimit or eLimit_
    for ($i = 0; $i < $eLimit; $i++) $e123usw[$i] = 'e'.$i;
    for ($i = 0; $i < $eLimit; $i++) $e[] = isset($$e123usw[$i]) ? $$e123usw[$i] : '';
   }
   else $e = isset($e) ? $e : $e_;                               // $e is array or set $e_
   $rec = isset($rec) ? $rec : $rec_;                            // set rec or rec_
   $rec = isset($recursive) ? $recursive : $rec;                 // set recursive or rec
   $maxTiefe = isset($maxTiefe) ? intval($maxTiefe) : $maxTiefe_;// recursion depth limit

   $end = isset($end) ? $end : $end_;                            // Only these Endings
   $notEnd = isset($notEnd) ? $notEnd : $notEnd_;                // Exclude these End.
   $endMode = isset($endMode) ? $endMode : $endMode_;            // z.B. letzten 2E pruefen
   $endMode = isset($mode) ? $mode : $endMode;                   // z.B. letzten 2E pruefen
   $base = isset($base) ? $base : $base_;                        // base in front or not
   $evolved = isset($evolved) ? $evolved : $evolved_;            // whether evolved or not
   $orderedMenu = isset($orderedMenu) ? $orderedMenu : $orderedMenu_;#:=no parameter!
   $orderBy = isset($orderBy) ? $orderBy : $orderBy_;            // orderIndex or false
   $orderMode = isset($orderMode) ? $orderMode : $orderMode_;    // sort: {asc|desc}
   $homeTop = isset($homeTop) ? $homeTop : $homeTop_;            // whether always first
   $homeAlwaysAtTop = isset($homeAlwaysAtTop) ? $homeAlwaysAtTop : $homeTop;
   $menuMap = isset($menuMap) ? $menuMap : $menuMap_;            // a menuMap or false
   $renderMenu = isset($renderMenu) ? $renderMenu : $renderMenu_; # whether to reorder


   $shortIDs_ = isset($short) ? $short : $shortIDs_;             //default true!
   $shortIDs_ = isset($shortID) ? $shortID : $shortIDs_;
   $shortIDs = isset($shortIDs) ? $shortIDs : $shortIDs_;        //without ending if poss

   $statics = isset($statics) ? $statics : $staticEntries_;      //i.e.http://...
   $staticEntries = isset($staticEntries) ? $staticEntries : $statics;


   //echo getcwd();
   $fs = new DynamicMenu($path, $type, $e, $rec, $maxTiefe, $end, $notEnd, $endMode,
                       $base,
                       $evolved, $orderedMenu, $orderBy, $homeAlwaysAtTop,
                       $menuMap, $staticEntries, $orderMode, $shortIDs);
                                                                 // create object
   if (!isset($_GET['build']) || ($_GET['build'] != 'off' && $_GET['build'] != false)) {
   if ($evolved) {
        $fs->lis = $fs->buildMenu();
        if (false)
        if ($orderedMenu || ($orderedMenu != 'off' && $orderedMenu != false)) {
            $fs->orderMenu($fs->lis);
        }
        if ($renderMenu || ($renderMenu != 'off' && $renderMenu != false)) {
            $fs->renderMenu();
        }
   }
   else {//already working version, but no menu sorting order or 1click-EN-Switch
        $fs->build();
        if (!isset($_GET['render']) || ($_GET['render'] != 'off' && $_GET['render'] != false))
            $fs->render();
        }
   }

}








//no includes
class DynamicMenu {
  /** === EIGENSCHAFTEN ================================================== **/
  //------EIGENSCHAFTEN----------private------------------------------------//
  //private $jetzt = getDate(time());
  private $dir = true;             // default: Mache Verzeichnisse zu Navigation
  private $files = false;          // default off
  private $hiddenIndicators = array('.', '#');
  private $exceptions = array('dir','img','css','js','db_connect.inc.php','.','..');
  
  private $onlyToFirstPoint = true;// z.B. .class.php von NavNamen abscheiden
  private $recursive = false;      // default: off
  private $base = '';
  private $homeDir = '';           //
  private $path = '';              //
  private $d;                      // for a Directory object instance
  private $results = array();      // as storage for results - filled $results[0.Ebene]=..
  private $res = array();          // as storage for results - filled $res[]=completePath
  private $tiefe = 0;              // makes styling the subnavs easier #nav2 li {}
  private $maxTiefe = 2;           // otherwise the performance suffers
  private $end = false;            // valid Endings
  private $notEnd = false;         // not valid Endings
  private $endMode = 'l';          // Endungs Modus ist last Endung!
  private $navMode = false;        // navMode = 'get' stellt die Navigation auf GET um!

  private $evolved = true;         // whether menu gets build the evolved way
  private $orderedMenu = true;     // whether to order the menu or not
  private $menuMap = false;        // whether a menu not exists or the $menuMap
  private $orderBy = 'filesize';   // filesize, but poss: {false|title|order(map)}
  private $homeAlwaysAtTop = true;
  private $orderMode = 'asc';      // either from great to small or the other way round
  private $shortIDs = true;        // either to set IDs without ending or not

  private $staticEntries = array();//statische absolute oder rel. Menulinks
  
  private $currentMarker = false;  // to react on a current marker that may be set

  //------EIGENSCHAFTEN----------public-------------------------------------//
  public $message = null;
  public $state = 'not busy';                                       // NAV DIV
  public $toGiveBack  = '<style type="text/css" href="./fileshark.css"></style><div id="nav">';
  public $toGiveBack_ = '</div>';           // NAV DIV -END






  /** === KONSTRUKTOREN ================================================== **/
  public function __construct($hD,$type,$excs, $rec=false,$maxTiefe=2,
                              $end=false,$nEnd=false,$eM=false, $b=false,
                              $evolved=true, $orderedMenu=true,
                              $orderBy='filesize', $homeAlwaysAtTop=true,
                              $menuMap=false, $staticEntries=false,
                              $orderMode='asc', $shortIDs = true) {
    $this->path = $this->homeDir = $hD;             // home_dir required
    $this->base = ($b != false ? $_SERVER['DOCUMENT_ROOT'] : '');

    //echo 'Type: '.$type;
    if (substr($this->homeDir,0,3) == '../'
      && sizeOf(explode('/',$this->homeDir)) == 0) chdir($this->homeDir);
    //echo getcwd();
    // Typ setzen
    switch ($type) {
      default:
        foreach ($excs as $e) {
          $this->exceptions[] = $e;                 // exception hinzufuegen
        }
        break;
      case 'dirget':
        $this->navMode = 'get';
      case 'dir':
        $this->dir = true;                          // aktivieren
        $this->files = false;                       // deaktivieren
        foreach ($excs as $e) {
          $this->exceptions[] = $e;                 // exception hinzufuegen
        }
        $this->exceptions = array_unique($this->exceptions);
      	break;
      case 'filesget':
        $this->navMode = 'get';
      case 'files':
        $this->dir = false;                         // deaktivieren
        $this->files = true;                        // aktivieren
        if (is_array($excs))
          foreach ($excs as $e) {
            $this->exceptions[] = $e;               // exception hinzufuegen
          }
        else $this->exceptions[] = $e;
        $this->exceptions = array_unique($this->exceptions);
      	break;
      case 'allget':
        $this->navMode = 'get';
      case 'all':
      case '':
      case null:
      case false:
      case 'everything':
        $this->dir = true;                          // aktivieren
        $this->files = true;                        // aktivieren
        foreach ($excs as $e) {
          $this->exceptions[] = $e;                 // exception hinzufuegen
        }
        $this->exceptions = array_unique($this->exceptions);
      	break;
    }
    // weitere Optionen setzen
    $this->recursive = ($rec) ? true : false;
    $this->maxTiefe = intval($maxTiefe);
    $this->endMode = ($eM != false) ? $eM : 'last';
    if ($end != false) {
      $this->end = array('');                       // array-type sichern
      if (is_array($end))
       foreach ($end as $v) $this->end[] = $v;      // auf Auswahl an End. einschraenken
      else $this->end[] = $end;
    }
    if ($nEnd != false) {
      $this->notEnd = array('');                    // array-type sichern
      if (is_array($nEnd))
       foreach($nEnd as $v) $this->notEnd[] = $v;   // Endungen die ni.auftauchen duerfen
      else $this->notEnd[] = $nEnd;
    }




    $this->base = dirname(__FILE__);

    //evolved - order by and generate general query string/type-link
    $this->evolved = $evolved;
    $this->orderedMenu = $orderedMenu;
    $this->orderBy = $orderBy;
    $this->menuMap = $menuMap;

    $this->homeAlwaysAtTop = $homeAlwaysAtTop;
    $this->orderMode = strtolower($orderMode);
    $this->staticEntries = is_array($staticEntries) ? $staticEntries : array();
    $this->shortIDs = $shortIDs ? true : false;
  }





  /** === METHODEN ======================================================= **/

  /*----------------
   * build         *
   *---------------*/
  public function build($results=null,$oVal='') {//Baut ein Menue anhand der Einstellungen
    if ($this->navMode != false) return $this->buildNav();
    // prep
    if (substr($this->homeDir,0,3) == '../'
      && sizeOf(explode('/',$this->homeDir)) != 0) $oVal = $this->homeDir;
    if ($results == null) $results = $this->read($this->homeDir);
    // tiefe wird immer vor tiefe++ geschrieben
    $this->toGiveBack .= '<ul id="tiefe'.$this->tiefe.'">'."\n";
    // uebergebene results durchgehen
    foreach ($results as $key => $val) {
      if ($this->end != false
        && array_search($this->getEnd($val,$this->endMode),$this->end) == false)
          continue;
      if ($this->notEnd != false
        && array_search($this->getEnd($val,$this->endMode),$this->notEnd) != false)
          continue;
      #current - marker
	echo 'val: ' . $val;
      if ( (isset($_GET['id']) && $_GET['id'] == $val)
           || (!isset($_GET['id']) && ($val == $startEN || $val == $startDE)) ) {
          $cToSet = ' current';
      }
      else $cToSet = '';
      $this->toGiveBack .= ''
       .'<li class="nav_li'.$cToSet.'">'
       .'<a href="../'.$oVal.'/'.$val.'" class="'.$cToSet.'">'
       .self::toFairy($val).'</a></li>';
      if ($this->recursive && is_dir($oVal.$val) && $this->tiefe < $this->maxTiefe) {
        $nOVal = ($oVal[$oVal.length-1]=='/' || $val[0]=='/') ? $oVal.$val : $oVal.'/'.$val;
        $this->tiefe++;
        $this->build($this->read($this->homeDir.'/'.$val),$nOVal);//read() returns results!

      }
    }
    $this->toGiveBack .= '</ul>'." \n";
  }

  /*----------------
   * buildNav      *
   *---------------*/
  public function buildNav($results=null, $oVal='') {//Baut Menuesystem anhand Settings
    //GET-VERSION
 $stglobalartEN;
    global $startDE;
    if ($this->navMode == false) return $this->build();
    // prep
    $this->path = $_SERVER['DOCUMENT_ROOT'].$_SERVER['PHP_SELF'];
    #fetches all the files/dirs/both..
    if (substr($this->homeDir,0,3) == '../'
      && sizeOf(explode('/',$this->homeDir)) != 0) {
      $oVal = $this->base.(preg_replace('/[.]{1,2}[/]/i', '', $this->homeDir));
    }
    if ($results == null) {
      $results = $this->read2($this->base.(preg_replace('/[.]{1,2}\//i','',$this->homeDir)));
    }
    // tiefe wird immer vor tiefe++ geschrieben

    // uebergebene results durchgehen
    foreach ($results as $val) {
      if ($this->end != false
        && array_search($this->getEnd($val,$this->endMode),$this->end) == false)
          continue;
      if ($this->notEnd != false
        && array_search($this->getEnd($val,$this->endMode),$this->notEnd) != false)
          continue;
      if (is_dir($this->base.$val) && $this->tiefe > 0) $val = $oVal.'.'.$val;
      #current - marker
      if ( (isset($_GET['id']) && $_GET['id'] == $val)
           || (!isset($_GET['id']) && ($val == $startEN || $val == $startDE)) ) {
          $cToSet = ' current';
      } else $cToSet = '';
      $this->toGiveBack .= '' //former $this->path -->$_SERVER['PHP_SELF']
        .'<li class="nav_li '.$cToSet.'">'
        .'<a href="'.$_SERVER['PHP_SELF'].self::addToQS('id',$val).'"'
        .' class="'.$cToSet.'">'.self::toFairy($val).'</a></li>';
      if ($this->recursive && is_dir($this->base.$val) && $this->tiefe < $this->maxTiefe) {
        $this->tiefe++;
        $this->buildNav($this->read2($this->base.$val), $val);//read2() returns results!
      }
    }
    $this->toGiveBack .= '</ul>'." \n";
  }

  /*----------------
   * backHome (ET:)*
   *---------------*/
  public function backHome() {
    $this->d = dir($this->homeDir); // aktuelle Home Directory class holen
  }



  /*----------------
   * read          *
   *---------------*/
  public function read($path) {
    $d = dir($path);                            // Directory pseudo class holen
    $results = array();                         // wird befuellt und zurueckgegeben

    while (($entry = $d->read()) !== false) {
      if (is_dir($entry) && $this->dir && array_search($entry,$this->exceptions) == false
          || !is_dir($entry) && $this->files && !array_search($entry,$this->exceptions)) {
        $results[] = $entry;
      }
    }
    $d->close();                                // Resource-Verbindungs beenden
    $this->results[] = $results;                // Results-Array inArray verfuegbar machen
    return $results;
  }

  /*----------------
   * r             *
   *---------------*/
  public function r($path) {
    $d = dir($path);                            // Directory pseudo class holen
    $results = array();                         // wird befuellt und zurueckgegeben

    while (($entry = $d->read()) !== false) {
      if (is_dir($entry) && $this->dir && array_search($entry,$this->exceptions) == false
          || !is_dir($entry) && $this->files && !array_search($entry,$this->exceptions)) {
        $results[] = $path.$entry;
      }
    }
    $d->close();                                // Resource-Verbindungs beenden
    foreach ($results as $val)
      $this->res[] = $val;                      // Results zu Attribut res hinzufuegen
    return $results;
  }

  /*----------------
   * read2         *
   *---------------*/
  public function read2($path) {
    $d = dirname(__FILE__);
    //echo '####'.realpath('../');
    //echo $d;
    $d = dir($d);                               // Directory pseudo class holen
    $results = array();                         // wird befuellt und zurueckgegeben

    while (($entry = $d->read()) !== false) {
      if (is_dir($entry) && $this->dir && array_search($entry,$this->exceptions) == false
          || !is_dir($entry) && $this->files && !array_search($entry,$this->exceptions)) {
        $results[] = $entry;
      }
    }
    $d->close();                                // Resource-Verbindungs beenden
    $this->results[] = $results;                // Results-Array inArray verfuegbar machen
    return $results;
  }




  /*----------------
   * render        *
   *---------------*/
  public function render() {
    echo $this->toGiveBack.$this->toGiveBack_;  // make the present
  }


  /*----------------
   * getEnd        *
   *---------------*/
  public function getEnd($toGetEndFrom, $part = 'last') {
    $res = explode('.', $toGetEndFrom);
    if (count($res) == 1) {
        return false;
    }
    switch ($part) {
      case 'last':
      case 'l':
        return $res[sizeof($res) - 1];

      case '2ndlast':
      case '2ndl':
      case '2l':
        return (sizeOf($res) > 1) ? $res[sizeOf($res) - 2] : false;
      case 'lastTwo':
      case 'last2':
      case 'l2':
        return (sizeOf($res) > 1) ? $res[sizeof($res)-2].'.'.$res[sizeOf($res)-1] : false;
    }
  }


  /*----------------
   * getResults    *
   *---------------*/
  public function getResults() {
    return $this->results;
  }


  /*----------------
   * getRes        *
   *---------------*/
  public function getRes() {
    return $this->res;
  }


  /*----------------
   * getHomeDir    *
   *---------------*/
  public function getHomeDir() {
    return $this->homeDir;
  }


  /*----------------
   * getPath       *
   *---------------*/
  public function getPath() {
    return $this->path;
  }










  //======== ORDERED SHARK - EVOLVED VERSION ================================//
  ########## MAIN ATTRIBUTE ###################################################
  public $lis = array();                    //contains also sublevels
                                            //shall allow special order



  ########### EVOLVED METHODS #################################################
  /**
   * generateLi
   * also need an attribute called tiefe to save the depth of nested menus
   * @param $title      -- meist Datei-Name toFairy() oder mapped English Title
   * @param $pathTo     -- Dateiname ...
   * @param $class      -- li-Klasse(n) [optional]
   * @param innerHTML   -- innerHTML z.B. <span>Good evening!</span> [optional]
   */
  function generateLi($title,$pathTo,$class='nav_li',$mDir=false,$innerHTML=false) {
        /* sets the following array-entries:
         * | title | pathTo | class | file | dir | order | filesize | class |
         * | depth |
         */
        //prep
        global $startEN;
        global $startDE;
        $startPages = array($startEN, $startDE);


        //static menu li to build?
        $staticBed = is_array($this->staticEntries)
           && !empty($this->staticEntries)
           && (isset($this->staticEntries[$title]) || in_array($pathTo,$this->staticEntries));




        //build LI
        $li['title'] = $title;
        //
        $li['pathTo'] = $pathTo;
        $dirsAndFile = explode('/', $pathTo);
        $dirsAndFileL = count($dirsAndFile);
        $li['file'] = $dirsAndFile[$dirsAndFileL - 1];
        //Angabe endet bei Verzeichnis? (kein Dateiname angegeben)
        $li['pathTo'] = $pathTo;
        if (!is_file($pathTo)) {
            //index?
            $d = dirname(__FILE__);
            if (file_exists($d.'/'.$pathTo.'/index.php')) {
                $li['file'] = 'index.php';
	            $pathTo .= '/'.$li['file'];
            }
            else if (file_exists($d.'/'.$pathTo.'/index.htm')) {
                $li['file'] = 'index.htm';
	            $pathTo .= '/'.$li['file'];
            }
            else if (file_exists($d.'/'.$pathTo.'/index.html')) {
                $li['file'] = 'index.html';
	            $pathTo .= '/'.$li['file'];
            }//home?
            else if (file_exists($d.'/'.$pathTo.'/home.php')) {
                $li['file'] = 'home.php';
	            $pathTo .= '/'.$li['file'];
            }
            else if (file_exists($d.'/'.$pathTo.'/home.htm')) {
                $li['file'] = 'home.htm';
	            $pathTo .= '/'.$li['file'];
            }
            else if (file_exists($d.'/'.$pathTo.'/home.html')) {
                $li['file'] = 'home.html';
	            $pathTo .= '/'.$li['file'];
            }
	    else {
                //TODO If no file in directory? Shall we abort and not display this directory in the menu?
                //echo 'Excluding directory as no index|home.php|html|htm file was find within it:' . $pathTo;
		//return null;
                //TODO better choose next best found file? Only then return null?
                //$li['file'] = null; //<-- if '' then we get in a endless loop it seems.
  		//return array("NEITHER INDEX.PHP|HTML|HTM NOR HOME.PHP|HTML|HTM FILE FOUND IN DIRECTORY: ".$d.'/'.$pathTo);
	    }
            //
//	    if (isset($li['file']) && !empty($li['file'])) {
                    $pathTo = preg_replace('/\/{2}/', '/', $pathTo);
//	    }
            $pathTo = str_replace('//', '/', $pathTo);

            $dirsAndFile = explode('/', $pathTo);
            $dirsAndFileL = count($dirsAndFile);
        }
        $li['dir'] = false;
        if ($dirsAndFileL > 1) {
            $li['dir'] = $dirsAndFile[$dirsAndFileL - 2];//2ndLast = dir!!
                                                         //last = filename!!
        }
        if (empty($li['dir']) && $mDir) {#motherDir
            $li['dir'] = $mDir;
        }
        #echo 'dir'.$li['dir'].' pathTo:'.$li['pathTo'].' file:'.$li['file']."\n";

        //
        $li['filesize'] = intval($this->savefilesize($pathTo));
        $li['class'] = $class;
        //
        #ORDER
        $li['order'] = 1000;
        if ($this->orderBy == 'random') {
            $li['order'] = mt_rand(0, 5000);
        }
        if ($this->menuMap && is_array($this->menuMap)) {

            $li['order'] = 1000;
            //short cuts => 1click-LanguageSwitch-AndGetCorrectPage
            if (in_array($title, $this->menuMap)) {
                $li['order'] = array_keys($this->menuMap, $title);
                $li['order'] = $li['order'][0];
            }
            else if (isset($this->menuMap[$title])) {
                $li['order'] = array_keys($this->menuMap, $this->menuMap[$title]);
                $li['order'] = $li['order'][0];
            }
            //filename with ending
            else if (in_array($li['file'], $this->menuMap)) {
                $li['order'] = array_keys($this->menuMap, $li['file']);
                $li['order'] = $li['order'][0];
            }
            else if (isset($this->menuMap[$li['file']])) {
                $li['order'] = array_keys($this->menuMap, $this->menuMap[$li['file']]);
                $li['order'] = $li['order'][0];
            }
        }
        //
        if (isset($_GET[$li['title']])) {
            $this->currentMarker = $li['title'];
        }
        #current - marker
        $qs = false;
        if (isset($_GET[$this->currentMarker])
            && (!isset($_GET['type']) || empty($_GET['type'])
                || $this->currentMarker != $li['title']) ) {
            #echo 'reached';
            $qs = $this->rmFromQSAndAdd($this->currentMarker);
            if (isset($_GET['loc'])) {
                $qs = $this->rmFromQSAndAdd('loc', false, false, $qs);
            }
            unset($_GET[$this->currentMarker]);
        }
        if (isset($_GET['loc'])) {
                $qs = $this->rmFromQSAndAdd('loc', false, false, $qs);
                $qs = $this->rmFromQSAndAdd('lehre', false, false, $qs);#added
                $qs = $this->rmFromQSAndAdd('lectures', false, false, $qs);#added
                #$qs = $this->rmFromQSAndAdd('type', false, false, $qs);#added (DragonTale)
        }
        
        //update: recognize file as current even though html entities in filename
        $GETIdPlusHtml = self::getParamPlusHtml((

		isset($_GET['id']) ? $_GET['id'] : ""
	));
        #echo ''.strtolower($GETIdPlusHtml).' == '.strtolower($li['title']).' == '
        #       .strtolower($li['file']).'<br />';
        if (isset($_GET['id'])
            && !$staticBed
            && (
                (strtolower($GETIdPlusHtml) == strtolower($li['title']))
                ||
                 strtolower($GETIdPlusHtml) == strtolower($li['file'])
            )
            || !isset($_GET['id']) && in_array($li['file'], $startPages) && !$staticBed
            || isset($_GET[$li['title']]) && !$staticBed
            || (isset($_GET['type']) && !$staticBed
                &&
                ($_GET['type'] == $li['file'] || $_GET['type'] == $li['title']))
            ) {
            $class .= ' current';
            #if ($li['hasChildren']) {
                $class .= ' mother parent';#in combination with current :)
            #}
        }
        if ($staticBed) {
            $class .= ' static';
        }
        //update: for optional use of html-entities 
        #$pathTo = htmlentities($pathTo);            #replaces all possible chars with
        #$li['pathTo'] = htmlentities($li['pathTo']);#their corresponding htmlequivalents
        //
        $li['innerHTML'] = '<a href="'.self::ampersandOfHtmlEntityToHtmlEntityItself( #update for html
                                      $pathTo
                                  ).'">'
                                  .ucfirst(html_entity_decode($title))
                                  .'</a>';
        if ($this->menuMap) {
            //static menu li to build?
            if ($staticBed) {
                  $href = $li['pathTo'];
                  $titleToSet = $title;
            }
            //no static entries exist => this li needs to be dynamic
            else {
                $href = $this->getLiAHref($li);
                $titleToSet = self::toFairy($li['title']);
            }
            //get keys as numeric and(?) string
            #$titleArK = array_keys($li['title']);       //array
            #$fileArK = array_keys($li['file']);         //array
            //
            $tArVal = false;
            if (isset($this->menuMap[$li['title']])) {
                $tArVal = $this->menuMap[$li['title']];  //array
            }
            $fArVal = false;
            if (isset($this->menuMap[$li['file']])) {
                $fArVal = $this->menuMap[$li['file']];  //array
            }
            //
              #TODO somehow use the above to translate and retranslate
              #     aim: ending no longer needed

            //
            $li['innerHTML'] = '<a href="' #nested addToQS call
                              .self::ampersandOfHtmlEntityToHtmlEntityItself( #update for html
                                  $href
                              )                                         #entities in filenames
                              .'" class="'.$class.'">'
                                  .ucfirst(html_entity_decode($titleToSet))
                              .'</a>';
        }
        else {
            //static menu li to build?
            if ($staticBed) {
                  $href = $li['pathTo'];
                  $titleToSet = $title;
            }
            //no static entries exist => this li needs to be dynamic
            else {
                $href = $this->getLiAHref($li);
                $titleToSet = self::toFairy($li['title']);
            }
            #$href = self::addToQS('type',$li['dir'],self::addToQS('id',$li['file'],$qs));
            $li['innerHTML'] = '<a href="' #nested addToQS call
                                .self::ampersandOfHtmlEntityToHtmlEntityItself( #update for html
                                    $href
                                )                                         #entities in filenames
                                .'" class="'.$class.'">'
                                    .html_entity_decode(ucfirst($titleToSet))
                                .'</a>';
        }

        //
        if ($innerHTML) {
            $li['innerHTML'] = $innerHTML;
        }
        $li['outerHTML'] = '<li class="'.$class.'">'.$li['innerHTML'].'</li>';
        //
        $li['depth'] = $this->tiefe;

        #gets saved to attribute in function read3
        return $li;
  }
  /**
   * getLiAHref
   * Returns the correct href-Attribute-string depending on the mode (get/direct)
   */
  function getLiAHref($li = false) {
        if (!$li) {
            return 'no li given';
        }
        //
        $qs = false;
        if (isset($_GET[$this->currentMarker])
            && (!isset($_GET['type']) || empty($_GET['type'])
                || $this->currentMarker != $li['title']) ) {
            $qs = $this->rmFromQSAndAdd($this->currentMarker);
            #unset($_GET[$li['title']);
        }
        if (isset($_GET['loc'])) {
            $qs = $this->rmFromQSAndAdd('loc', false, false, $qs);
            $qs = $this->rmFromQSAndAdd('lehre', false, false, $qs);#added (DragonTale);
            $qs = $this->rmFromQSAndAdd('lectures', false, false, $qs);#added (DragonTale);
        }
        if (isset($_GET['type'])
               && strtolower($_GET['type']) != strtolower($li['dir'])) {
            $qs = $this->rmFromQSAndAdd('type', false, false, $qs);
        }
        //
        if ($this->navMode == 'get') {
            if (false && is_dir(self::getLang().'/'.$li['file'])) {
                return self::addToQS('type',$li['file'], self::addToQS('id',$li['file'],$qs));
            }
            #echo $li['dir'];
            $lif = $li['file'];
            if (is_array($this->end)) {
                //ohne Endungen fuer die ID, falls verfuegbar
                foreach ($this->end as $ending) {
                    if (empty($ending)) {
                        continue;
                    }
                    #echo $ending.' liFile: '.$lif.'<br />';
                    $lif = preg_replace('/[.]'.$ending.'/', '', $lif);
                    #echo '  &nbsp;lif:'.$lif.'<br /><br />';
                }
                //
                return self::addToQS('type',$li['dir'],self::addToQS('id',$lif,$qs));
            }
            else if (is_string($this->end)) {
                $lif = preg_replace('/[.]'.$this->end.'/', '', $lif);
                //
                return self::addToQS('type',$li['dir'],self::addToQS('id',$lif,$qs));
            }
            else if ($this->shortIDs) {
                $endings = array('php','php5','php4','html','htm','js','css',
                                'jsp','txt','pdf','ps','class','java','cpp',
                                'c','has','xml','xul','sql','xhtml','tex','lyx');
                //ohne Endungen fuer die ID, falls verfuegbar
                foreach ($endings as $ending) {
                    if (empty($ending)) {
                        continue;
                    }
                    #echo $ending.' liFile: '.$lif.'<br />';
                    $lif = preg_replace('/[.]'.$ending.'/', '', $lif);
                    #echo '  &nbsp;lif:'.$lif.'<br /><br />';
                }
                //
                return self::addToQS('type',$li['dir'],self::addToQS('id',$lif,$qs));
            }
            return self::addToQS('type',$li['dir'],self::addToQS('id',$li['file'],$qs));
        }
        else {
            return $li['dir'].'/'.$li['file'];
        }
  }
  /**
   * orderMenu
   * @param $lis:array -- das nach settings zu sortierende Array of entries
   */
  function orderMenu($lis = null) {
        global $startDE;
        global $startEN;
        //
        if ($lis == null) {
            $lis = $this->lis;
        }
        if (!is_array($lis)) {
            return $lis;
        }
        //
        #uasort($lis, 'reorder');     #own function used [see function below]


        //The string which tells which index toSort is set in configuration at the beginning.
        $schatz = array();
        $truhe = intval(0);
        $toSort = $this->orderBy or 'filesize';
        if ($this->orderBy == 'random' || $this->orderBy == 'randomMap') {
            $toSort = 'order';
        }
        #echo "\n<br />".'reached';
        //
        $lisL = count($lis);
        switch ($this->orderMode) {
        default :
        case 'asc':
        case 'ascending':
           //makes i.e. filesize and menuMap possible (first sorting)
           for ($i = 1; $i < $lisL; $i++) {
             #echo $lis[$i][$toSort];
             $schatz = $lis[$i];
             $truhe = $lis[$i][$toSort];       //INSERTION SORT
             $j = $i - 1;
             while ($j > -1 && $lis[$j][$toSort] > $truhe) {
                $lis[$j + 1] = $lis[$j];       //umsortieren (swap/exchange)
                $j--;
             }
             $lis[$j + 1] = $schatz;
           }
           //menuMap - sortiert stabil & erhaelt somit non-map El Vorsortierung
           if (is_array($this->menuMap) && $this->orderBy != 'order') {
             #duetoperformance
             for ($i = 1; $i < $lisL; $i++) {
               $schatz = $lis[$i];
               $truhe = $lis[$i]['order'];       //INSERTION SORT
               $j = $i - 1;
               while ($j > -1 && $lis[$j]['order'] > $truhe) {
                  $lis[$j + 1] = $lis[$j];       //umsortieren (swap/exchange)
                  $j--;
               }
               $lis[$j + 1] = $schatz;
             }
           }
           break;

        case 'desc':
        case 'descending':
           //makes i.e. filesize and menuMap possible (first sorting)
           for ($i = 1; $i < $lisL; $i++) {
             $schatz = $lis[$i];
             $truhe = $lis[$i][$toSort];       //INSERTION SORT
             $j = $i - 1;
             while ($j > -1 && $lis[$j][$toSort] < $truhe) {
                $lis[$j + 1] = $lis[$j];       //umsortieren (swap/exchange)
                $j--;
             }
             $lis[$j + 1] = $schatz;
           }
           //menuMap - sortiert stabil & erhaelt somit non-map El Vorsortierung
           if (is_array($this->menuMap) && $this->orderBy != 'order') {
             #performance
             for ($i = 1; $i < $lisL; $i++) {
               $schatz = $lis[$i];
               $truhe = $lis[$i]['order'];       //INSERTION SORT
               $j = $i - 1;
               while ($j > -1 && $lis[$j]['order'] < $truhe) {
                  $lis[$j + 1] = $lis[$j];       //umsortieren (swap/exchange)
                  $j--;
               }
               $lis[$j + 1] = $schatz;
             }
           }
           break;
        }
        //homeAlwaysAtTop?
        if ($this->homeAlwaysAtTop !== false && $this->homeAlwaysAtTop !== 'false'
            && (isset($startDE) || isset($startEN))
            && ($this->inLis($startEN, $lis) || $this->inLis($startDE, $lis))) {
            $homeli = false;
            //home li suchen
            //alles +1 im Index umkopieren, bis home li gefunden
            $schatz = $lis[0];                 //speichere init-li
            for ($i = 1; $i <= $lisL; $i++) {
                $ili = $lis[$i];
                //homeli gefunden?
                if ($schatz['file'] != false
                    && ($schatz['file'] == $startDE || $schatz['file'] == $startEN)) {
                    $homeli = $schatz;
                    break;
                }
                //sonst prev-li eins an i-li's index verschieben
                $lis[$i] = $schatz;
                //und $ili wird fuer die naechste Runde zu prev-i-li
                $schatz = $ili;
            }
            //
            if ($homeli) {
                $lis[0] = $homeli;
            }
        }
        //
        return $lis;

  }
  
  /**
   * inLis
   * @param $needles  -- either array of needles or one needle(file to look for)
   * @param $haystack -- the haystack where the needle is supposed to got lost
   * @param $mode     -- ENUM('or','and'): by default test if one needle exists
   *                     (nur relevant, wenn ein Array als $needles uebergeben)
   */
  function inLis($needles, $haystack, $mode = 'or') {#default 'or' ()
        if (!is_array($needles)) {
            $needle = $needles;
            foreach ($haystack as $li) {
                if ($li['file'] == $needle) {
                    return true;
                }
            }
            return false;
        }
        if ($mode == 'or') {
            foreach ($haystack as $li) {
                if (in_array($li['file'], $needles)) {
                    return true;
                }
            }
        }
        else {#modus 'and' - every needle needs to exist
            foreach ($needles as $needle) {
                if (!$this->inLis($needle, $haystack)) {
                    return false;
                }
            }
            return true;
        }
  }
  
  
  

  /**
   * reorder
   * Tells in which way uasort shall reorder the array reference
   */
  function reorder($a, $b) {
        if ($this->homeAlwaysAtTop && $this->orderBy == 'title') {
            switch (strtolower($a['title'])) {
            case 'home':
            case 'startseite':
            case 'index':
                return -1;

            }
            //switch
            switch (strtolower($b['title'])) {
            case 'home':
            case 'startseite':
            case 'index':
                return +1;
            }
        }
        //sonst ganz normal weiter pruefen,vergleichen,umsortieren (arrangieren)
        if ($a[$this->orderBy] == $b[$this->orderBy]) {
            return 0;
        }
        if ($a[$this->orderBy] < $b[$this->orderBy]) {
            return -1;
        }
        return +1;
  }






  /*-------------------------
   * buildMenu              *
   * dynamic menu evolved   *
   *------------------------*/
  public function buildMenu($lis = null, $oVal='', $submenu = false,  $dirfound_one_level_higher = null) {

  
    //Baut Menuesystem anhand Settings
    //EVOLVED GET-VERSION [with ORDER options]

    if ($lis == null) {
      $lis = $this->read3($this->base.(preg_replace('/[.]{1,2}\//i','',$this->homeDir)), $submenu);
    }
    $finalLis = array();
    // durch read3 ermittelte $lis durchgehen und aussortieren
    foreach ($lis as $li) {
      $liEnd = $this->getEnd($li['pathTo']);
      if ($this->end != false
        && (array_search($this->getEnd($li['pathTo'],$this->endMode),$this->end) == false)
        && $liEnd && !empty($liEnd))
          continue;
      if ($this->notEnd != false
        && array_search($this->getEnd($li['pathTo'],$this->endMode),$this->notEnd) != false)
          continue;
      //
      $finalLis[] = $li;
    }
    #print_r($lis);
    #echo '<br /><br />';
    #print_r($finalLis);
    #echo '<br /><br /><br /><br />';

    // die aussortierten finalen lis durchgehen - ggfs rekursiv
    $tiefer = false; //<-- if one of the lis goes in recursion, we increase the global depth counter. (only once per layer)
    foreach ($finalLis as $key => $li) {
        //echo $key .' -> '. $li.' pathTo='.$li['pathTo'] .'<br/>';
	if ($li == null || !isset($li) || empty($li) || $li['file'] == null /*hence pathTo points to the motherDir => endless recursion*/
			|| !isset($li['pathTo']) || empty($li['pathTo'])) {

		continue;
	}
      //print_r($li);
      //because only once per level.
//      $tiefer = false;
      $dirfound = false;
      if (is_dir($this->base.'/'.$li['pathTo'])) {
        $dirfound = $this->base.'/'.$li['pathTo'];
      }
      elseif (is_dir($this->base.(self::getLang()).'/'.$li['pathTo'])) {
        $dirfound = $this->base.(self::getLang()).'/'.$li['pathTo'];
      }
      elseif (is_dir(dirname(__FILE__).'/'.$li['pathTo'])) {
        $dirfound = dirname(__FILE__).'/'.$li['pathTo'];
      }
      elseif (is_dir(self::getLang().'/'.$li['pathTo'])) {
        $dirfound = self::getLang().$li['pathTo'];
      }
      //

      if ($dirfound_one_level_higher != null && $dirfound == $dirfound_one_level_higher) {
		// => avoid endless loop (it's a double)
                return null;
      }


      $li['hasChildren'] = false;
      if ($this->recursive && $dirfound !== false 
          && $this->tiefe < $this->maxTiefe) {
        //if this li has reached deeper level. (currently only globally used.)
        $tiefer = true;
        //read3() returns $lis!
        //echo 'reached recursion: dirfound '.$dirfound;


        $finalLis[$key]['hasChildren'] = $this->buildMenu($this->read3($dirfound, $tiefer), '', true, $dirfound);
        #echo 'hasChildren:';
        #print_r($li['hasChildren']);
      }
    }
    if ($tiefer) {
        $this->tiefe++;
    }
    #echo 'finalLis: ';
    #print_r($finalLis);
    #echo '<br />';
    //
    return $finalLis;
  }


  /*----------------
   * read3         *
   *---------------*/
  public function read3($dirpath = false, $submenu = false) {
    //
    $d = dirname(__FILE__);
    if ($dirpath) {
        if (is_file($dirpath) && !is_dir($dirpath)) {
            $dirpath = dirname($dirpath);
        }
        #echo $dirpath.'<br />';
        #define('BASE_PATH', realpath('.'));
        $d = $dirpath;
    }
    //echo '####'.realpath('../');
    //echo $d;
    $d = dir($d);             // Directory pseudo class holen
    #echo is_object($d) ? 'erfolg' : 'misserfolg';
    $lis = array();                             // wird befuellt und zurueckgegeben

    while (($entry = $d->read()) !== false) {
        $ending = $this->getEnd($entry);
        $firstChar = substr($entry, 0, 1);
        if (array_search($firstChar, $this->hiddenIndicators) !== false) {
            continue; #=> file shall not occur in (dynamic) menu
        }
        if (is_dir($entry)
                && $this->dir && array_search($entry,$this->exceptions) == false
            || !is_dir($entry) && $ending != false && $ending != ''
                && $this->files && !array_search($entry,$this->exceptions)) {
            //
            #echo $entry."\n";
            #echo $this->dir ? ' true ' : ' false';
            #buildLi - $title, $pathTo, ...
            $filename = str_replace('.'.$this->getEnd($entry), '', $entry);
            #echo $filename;
            $classToSet = 'inline';
            if ($this->tiefe > 0) {
                $classToSet = 'none';
            }
            //get motherDir
            $mDir = false;
            if ($dirpath && $submenu) {
                $dirs = explode('/', $dirpath);
                #$mDir = $dirs[count($dirs) - 1];
                $mDirIndex = count($dirs) - 1;
                if (isset($dirs[$mDirIndex])) {
                    $mDir = $dirs[$mDirIndex];
                }
            }
            $lis[] = $this->generateLi($filename,$entry,'nav_li '.$classToSet,$mDir);
        }
    }
    $d->close();                                // Resource-Verbindungs beenden
    //additional static menu entries
    foreach ($this->staticEntries as $ent) {
        if ($submenu) {
            break;
        }
        $parts = explode('/',$ent);
        $file = $parts[count($parts) - 1];
        $filename = str_replace('.'.$this->getEnd($file), '', $file);
        $title = $filename;
        //
        $arK = array_keys($this->staticEntries, $ent);
        foreach ($arK as $key) {
            if (is_string($key)) {
                $title = $key;
            }
        }
        //make a static genearteLi call
        $lis[] = $this->generateLi($title, $ent, 'nav_li');
    }
    //reorder menu
    if ($this->orderedMenu) {
        $lis = $this->orderMenu($lis);
    }
    #$this->tiefe++;
    #print_r($lis);
    return $lis;
  }



  /**
   * renderLevel
   * builds output recursively ..
   * if the level changes i.e. from 0 to 1, then it goes deeper
   *   and concats the resulting output-string to the parent li
   * @param $lisSub -- zu Beginn erste Ebene, dann Subarray eines $this->lis-Entry
   * @param $level  -- Abbruchbed.
   */
  function renderLevel($lisSub, $level = 0, $motherLi = false) {
      //
      $out = '';
      $cToS = ' block';
      $bed = $level > 0
                && isset($_GET['id'])
                && $_GET['id'] != $motherLi['file']
                && $_GET['id'] != $motherLi['dir']
                && $_GET['id'] != $motherLi['title']
                && (!isset($_GET['type'])
                || $_GET['type'] != $motherLi['file']
                && $_GET['type'] != $motherLi['dir']
                && $_GET['type'] != $motherLi['title']
                )
                ;
      if ($bed) {
        #echo 'Bed.: true<br /><br />';
        $cToS = ' none';
      }# else echo 'Bed.: false ('.$_GET['type'].')<br /><br />';
      if ($cToS != ' block') {
        $cToS = '';
      }
      $out .= $motherLi ? $this->getLi('', $cToS, $motherLi) : '';
      $out .= $this->getUl('tiefe'.$level, 'nav_ul'.$cToS, 'notype');
      $tiefer = false;

      foreach ($lisSub as $li) {
          // If for a directory no file to be included was found (currently only index|home.php|html|htm are examined), then we not show this directory in the menu. => Directories only in menu if index.php ! Comes in handy as no prepending with . or # is necessary to exclude it. So by default a directory is not shown.
          if ($li == null || !isset($li) || empty($li)) {
		continue;
          }
          //
          #$out .= $bed ? $this->getLi().$li['innerHTML'] : $li['outerHTML'];
          $out .= $li['outerHTML'];
          #echo 'reached -- innerHTML: '.$li['innerHTML'].'<br />';
          #echo 'reached -- hasChildren: '.$li['hasChildren'].'<br />';

         
         if (isset($li['hasChildren']) && $li['hasChildren']) {
              #print_r($li['innerHTML']);
              //nur einmal erhoehen pro renderLevel
              if (!$tiefer) {
                $level++;
              }
              $tiefer = true;
              #print_r($li['hasChildren']);
              $out .= $this->renderLevel($li['hasChildren'], $level, $li);
          }

          //
          #$out .= $bed ? $this->getLi_() : '';
      }
          
      $out .= $this->getUl_();
      $out .= $motherLi ? $this->getLi_() : '';

      // keine LIs mehr auf dieser Navigationsebene
      return $out;
  }


  /**
   * renderMenu
   * finally 'outputs' the evolved dynamic menu
   */
  function renderMenu() {
      echo $this->renderLevel($this->lis)
        .'<style type="text/css">/*<[CDATA[*/'."\n"
            .'/*better twice than not at all*/'."\n"
            .'.none { display: none !important; }'."\n"
            .'.inline { display: block; }'."\n"
        .'/*]]>*/</style>';
  }







  //=======HELPER===========================================================//
  /*----------------
   * toFairy       *
   *---------------*/
  static function toFairy($string) {
    if (!is_string($string)) ''.$string.'';
    $string = trim($string);
    $string .= ' ';
    $vP = explode('.', substr($string, 1, strlen($string) - 1));// vor punkt
    $oL = explode('_', $vP[0]);                                 // only last
    /*former version
    return strtoupper($string[0]).$oL[0]
    .(sizeOf($oL) > 1 ? ' '.strtoupper($oL[1][0]).substr($oL[1].' ',1,$oL.length-1) : '')
    .(sizeOf($oL) > 2 ? ' '.strtoupper($oL[2][0]).substr($oL[2].' ',1,$oL.length-1) : '');
    */

    //more universal approach
    $fairy = strtoupper($string[0]).$oL[0];
    for ($i = 1; $i < sizeOf($oL); $i++) {
        $fairy .= ' '.strtoupper($oL[$i][0]).substr($oL[$i].' ', 1, strlen($oL[$i]) - 1);
    }
    return $fairy;
  }

  /**
   * savefilesize
   * @param $file     -- path to file to get size from
   * @return          -- filesize, if file exists [unit: Bytes]
   *                  -- '-'     , otherwise
   */
  public function savefilesize($file){
      if (file_exists($file)) {
          return filesize($file).' B';
      }
      return '0 Bytes';
  }
  /**
   * getUl
   * returns the begin tag of an ul tag
   */
  function getUl($id = '', $class = '', $type = '') {
      return '<ul id="'.$id.'" class="'.$class.' ' .$id. '" type="'.$type.'">';
  }
  /**
   * getUl_
   * returns the end tag of an ul tag
   */
  function getUl_() {
      return '</ul>'."\n";
  }
  /**
   * getLi
   * returns the begin tag of an li tag
   */
  function getLi($id = '', $class = 'nav_li', $li) {
        #if there was no page id set, there would be a problem without
        global $startEN;     # these
        global $startDE;     # globals
        $startPages = array($startEN, $startDE);

        #current - marker
        if (isset($_GET['id'])
            && (
                (strtolower($_GET['id']) == strtolower($li['title']))
                ||
                 strtolower($_GET['id']) == strtolower($li['file'])
            )
            || !isset($_GET['id']) && in_array($li['file'], $startPages)) {
            $class .= ' current';
        }
        return '<li id="'.$id.'" class="'.$class.'">';
  }
  /**
   * getLi_
   * returns the end tag of an li tag
   */
  function getLi_() {
      return '</li>'."\n";
  }
  
  
  
  /**
   * addToQS
   */
  public static function addToQS($param, $value, $qs = false) {
    if ($qs) {
        $qs = str_replace('?', '', $qs); //das ? am Anfang des Strings entfernen
    }
    elseif (!$qs) {
        $qs = $_SERVER['QUERY_STRING'];
    }
    #$qs =  str_replace('&amp;', '&', $qs); //um htmlentities zu ermoeglichen

    //
    if (empty($value)) {
        return '?'.$qs;
    }
    if (strlen($qs) == 0) {
      return '?'.$param.'='.$value;
    }
    else if (strpos($qs, $param) === FALSE) {
      return '?'.$qs.'&'.$param.'='.$value;
    }
    else {
      $valueRegex = '[a-zA-Z0-9+-_%~.]*([&]amp[;][#]?[a-zA-Z0-9]+[;])?([.]{0,1}[a-zA-Z]+)*';
      $qs = '?'.preg_replace('/'.$param.'='.$valueRegex.'/i',$param.'='.$value,$qs);
      $qs = str_replace('&&','&', $qs);
      $qs = preg_replace('/&$/','', $qs);
      $qs = str_replace('type=&','', $qs);
      $qs = preg_replace('/[&]type[=]$/','', $qs);
      return str_replace('??', '?', $qs);
    }
  }
  
  
  /**
   * rmFromQSandAdd
   * Entfernt 1 GET Parameter und fuegt 1 GET Parameter hinzu, bzw. ersetzt !
   * @param $nameToRemove -- Variablen-Name des zu entfernenden Parameters
   * @param $name         -- Variablen-Name des zu setzenden Parameters
   * @param $val          -- Variablen-Wert des zu setzenden GET-Parameters
   */
  function rmFromQSandAdd($nameToRemove, $name = false, $val = false, $qs = false) {
      if (!$qs) {
        $qs = $_SERVER['QUERY_STRING'];
      }
      //remove if set parameter $nameToRemove
      $valueRegex = '[a-zA-Z0-9+-_%~.]+([.]?[a-zA-Z]+)*';
      $qs = preg_replace('/'.$nameToRemove.'='.$valueRegex.'[&]?/', '', $qs);

      //
      $qs = str_replace($nameToRemove.'=&','', $qs);
      $qs = preg_replace('/'.$nameToRemove.'=$/i', '', $qs);
      if (!$name) {
          return '?'.$qs;
      }
      //
      $qs = preg_replace('/[&]type[=]$/', '', addToQS($name, $val, $qs));
      $qs = str_replace('type=&','', $qs);
      $qs = str_replace('lehre=&','', $qs);
      $qs = preg_replace('/[&]$/','', $qs);
      $qs = str_replace('??','?', $qs);
      return str_replace('?&', '?', $qs);
  }


  
  /**
   * ampersandOfHtmlEntityToHtmlEntityItself
   * Ersetzt & einer html entity (z.B. &larr;) mit &amp; (im Bsp. => &amp;larr;)
   * @param $urlPart -- Zeichenkette, dessen & zu untersuchen
   */
  static function ampersandOfHtmlEntityToHtmlEntityItself($urlPart) {
        $urlPartNew = '';
        $urlPartL = strlen($urlPart);    #FileName's length
        $pos = 0;
        //velocity boost (? i doubt it would be)
        #if (strpos('&', $urlPart) == -1) {
        #    return $urlPart;
        #}
        while ($pos < $urlPartL) {

            $charAtPos = substr($urlPart, $pos, 1);
            
            if ($charAtPos != '&') {
                $urlPartNew .= $charAtPos;
                $pos ++;
                continue;
            }
           
            
            //else: is there a semicolon coming before another ampersand arrives at the moon?
            #the chars following and the posChar (inclusive) for further investigation
            $urlPartPart = substr(strtolower($urlPart), $pos);
            
            #is this ampersand the beginning of a html-entity?
            $isHtmlEntity = self::isSemicolonFollowingBeforeNextAmpersand($urlPartPart);
             
            $urlPartNew .= $charAtPos;
            if ($isHtmlEntity) {
                //echo $urlPartNew.'reaCHED <br />';
                $urlPartNew .= 'amp;';
            }
            
            $pos ++;
            
        }


        return $urlPartNew;
  }


  /**
   * isSemicolonFollowingBeforeNextAmpersand
   * @param $toInvestigate -- beliebige Zeichenkette
   * @return true          -- falls html Entitaet am Wortanfang
   *         false         -- andernfalls (fuer Gleichberechtigung:)
   */
  static function isSemicolonFollowingBeforeNextAmpersand($toInvestigate) {
      return preg_match('/^&[^&]+[;]{1}.*/i', $toInvestigate);
  }


  /**
   * getSignsTillNextChar
   * Extrahiert einen Teil einer Zeichenkette bis zum Aufkommen eines bestimmten
   * Terminierzeichens. Exklusive diesem.
   * @param $haystack -- die Zeichenkette
   * @param $char     -- das Zeichen bis zu dem die Zeichenkette zu extrahieren ist
   * @param $offset   -- der Zeichenketten-Index, ab dem zu suchen
   */
  static function getSignsTillNextChar($haystack, $char = ';', $offset = 0) {
    //ab Offset bis zum Ende der Zeichenkette extrahieren
    $hay = substr($haystack, $offset);
    $hayL = strlen($hay);
    //
    $extracted = ''; 
    $pos = -1;
    $actuallyInvestigated = '';
    while (++$pos < $hayL) {
        $actuallyInvestigated = substr($hay, $pos, 1);
        if ($actuallyInvestigated == $char) {
            break;
        }
        $extracted .= $actuallyInvestigated;
    }
    if ($extracted == $hay) {
        //Zeichenkette erhaelt kein solches Terminier-Zeichen
        return '';//false;
    }
    return $extracted;
  }


  /**
   * getIdPlusHtml
   * Falls sich HTML-Entititaeten hinter dem Wert eines $_GET-Parameters  befinden,
   * so werden diese noch zu dem Wert des vorangegangenen Parameters dazugezaehlt.
   * @param $GETParam    -- Inhalt einer super globalen Variable $_GET['param']
   */
  static function getParamPlusHtml($GETParam) {
      $GETParamPlusHtml = $GETParam;
      $valueRegex = '/'.$GETParam.'&amp;[#]?[a-zA-Z0-9]+;/';
      if (preg_match($valueRegex, $_SERVER['QUERY_STRING'])) {
          $beginIdAmpIndex = strpos($_SERVER['QUERY_STRING'], $GETParam.'&amp;');
          $offset = $beginIdAmpIndex + strlen($GETParam) + strlen('&amp;');
          $teddy = '&';
          $GETParamPlusHtml .= '&amp;'.self::getSignsTillNextChar(
                  $_SERVER['QUERY_STRING'], $teddy, $offset
          );
      }
      return $GETParamPlusHtml;
  }



  /**
   * self::getLang
   * Ermittelt die gesetzte Sprache
   */
  public static function getLang() {
      return (isset($_GET['lang']) && $_GET['lang'] == 'en' ? 'en' : 'de');
  }





};

?>

