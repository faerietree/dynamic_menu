<?php
/*------------------------------------------------------------------------
DynamicMenu.class.php
AutoMode enabled by default
License: CC-BY-SA, FairyTale Productions
*/


// $auto has to be switched off on include, because include() doesn't like parameters!
/*
Default actions	-- automatically executed if file is included - to deactivate manually
*/
if (!isset($_GET['auto']) && !isset($auto) || ($_GET['auto'] != 'off' && $auto != 'off'))
{
	// set home path
	$path_ = isset($_GET['home_dir']) ? $_GET['home_dir'] : './';
	$path_ = isset($_GET['path']) ? $_GET['path'] : $path_;

	// set type to all|files|dir
	$type_ = isset($_GET['type']) ? $_GET['type'] : 'dir';
	$e_	= array('', '');
	if (isset($_GET['e']) && !is_array($_GET['e']))
	{
		$e_[]	= $_GET['e'];
		$eLimit_ = isset($_GET['eLimit']) ? $_GET['eLimit'] : 3;
		for ($i = 0; $i < $eLimit; $i++)
		{
			$e_[] = isset($_GET['e'.$i]) ? $_GET['e'.$i] : '';
		}
	}
	else
	{
		// e is array => &e[]= !!
		$e_ = isset($_GET['e']) ? $_GET['e'] : $e_;
	}

	// recursion
	$rec_ = isset($_GET['rec']) ? $_GET['rec'] : false;
	$rec_ = isset($_GET['r']) ? $_GET['r'] : $rec_;
	$rec_ = isset($_GET['recursive']) ? $_GET['recursive'] : $rec_;
	$maxDepth_ = isset($_GET['maxDepth']) ? $_GET['maxDepth'] : 2;
	$maxDepth_ = isset($_GET['depth']) ? $_GET['depth'] : $maxDepth_;

	// desired endings
	$end_ = (isset($_GET['end'])) ? $_GET['end'] : false;
	// forbidden endings
	$notEnd_ = (isset($_GET['notEnd'])) ? $_GET['notEnd'] : false;
	// whether to check the last two endings or only the last
	$endMode_ = (isset($_GET['endMode'])) ? $_GET['endMode'] : 'l';
	$endMode_ = (isset($_GET['mode'])) ? $_GET['mode'] : $endMode_;

	// base dir pre or not
	$base_ = (isset($_GET['b'])) ? $_GET['b'] : true;
	$base_ = (isset($_GET['base'])) ? $_GET['base'] : $base_;

	$orderedMenu_ = isset($_GET['orderedMenu']) ? $_GET['orderedMenu'] : true;
	// orderIndex or false
	$orderBy_ = isset($_GET['orderBy']) ? $_GET['orderBy'] : false;
	$orderMode_ = isset($_GET['orderMode']) ? $_GET['orderMode'] : 'asc';
	// whether home shall come first at all times
	$homeTop_ = isset($_GET['homeTop']) ? $_GET['homeTop'] : true;
	$homeTop_ = isset($_GET['homeAlwaysAtTop']) ? $_GET['homeAlwaysAtTop'] : $homeTop_;

	// custom reorder
	$menuMap_ = isset($_GET['menuMap']) ? $_GET['menuMap'] : false;

	$renderMenu_ = isset($_GET['renderMenu']) ? $_GET['renderMenu'] : true;

	// Without ending if possible if true but conflict danger if dir == filename
	$shortIDs_ = isset($_GET['shortIDs']) ? $_GET['shortIDs'] : true;
	$shortIDs_ = isset($_GET['shortID']) ? $_GET['shortID'] : $shortIDs_;
	$shortIDs_ = isset($_GET['short']) ? $_GET['short'] : $shortIDs_;

	// i.e. http://... or https://...
	$statics_ = isset($_GET['statics']) ? $_GET['statics'] : array();
	$staticEntries_ = isset($_GET['staticEntries']) ? $_GET['staticEntries'] : $statics_;

	$circular_ = isset($_GET['circular']) ? $_GET['circular'] : false;
	$origin_ = isset($_GET['origin']) ? $_GET['origin'] : ['50%', '50%'];
	$radius_ = isset($_GET['radius']) ? $_GET['radius'] : 50;
	$unit_ = isset($_GET['unit']) ? $_GET['unit'] : '%';



	/*
	variables set just before include -- if not then $_GET values or default
	*/
	$path = isset($path) ? $path : $path_;
	$path = isset($home_dir) ? $home_dir : $path;
	$type = isset($type) ? $type : $type_;
	if (isset($e) && !is_array($e))
	{
		$e[] = $e;
		$eLimit = isset($eLimit) ? $eLimit : $eLimit_;
		for ($i = 0; $i < $eLimit; $i++) $e123usw[$i] = 'e'.$i;
		for ($i = 0; $i < $eLimit; $i++) $e[] = isset($$e123usw[$i]) ? $$e123usw[$i] : '';
	}
	else
	{
		// $e is array or set $e_
		$e = isset($e) ? $e : $e_;
	}
	// set rec or rec_
	$rec = isset($rec) ? $rec : $rec_;
	// set recursive or rec
	$rec = isset($recursive) ? $recursive : $rec;
	// recursion depth limit
	$maxDepth = isset($maxDepth) ? intval($maxDepth) : $maxDepth_;

	// Only these Endings
	$end = isset($end) ? $end : $end_;
	// Exclude these End.
	$notEnd = isset($notEnd) ? $notEnd : $notEnd_;
	// e.g. check the last two endings
	$endMode = isset($endMode) ? $endMode : $endMode_;
	$endMode = isset($mode) ? $mode : $endMode;
	// base in front or not
	$base = isset($base) ? $base : $base_;

	$orderedMenu = isset($orderedMenu) ? $orderedMenu : $orderedMenu_;  // :=no parameter!
	$orderBy = isset($orderBy) ? $orderBy : $orderBy_;  // orderIndex or false
	$orderMode = isset($orderMode) ? $orderMode : $orderMode_;  // sort: {asc|desc}
	$homeTop = isset($homeTop) ? $homeTop : $homeTop_;  // whether always first
	$homeAlwaysAtTop = isset($homeAlwaysAtTop) ? $homeAlwaysAtTop : $homeTop;
	$menuMap = isset($menuMap) ? $menuMap : $menuMap_;  // a menuMap or false
	$renderMenu = isset($renderMenu) ? $renderMenu : $renderMenu_; // whether to reorder

	$shortIDs_ = isset($short) ? $short : $shortIDs_;
	$shortIDs_ = isset($shortID) ? $shortID : $shortIDs_;
	$shortIDs = isset($shortIDs) ? $shortIDs : $shortIDs_;

	$statics = isset($statics) ? $statics : $staticEntries_;
	$staticEntries = isset($staticEntries) ? $staticEntries : $statics;

	$circular = isset($circular) ? $circular : $circular_;
	$origin = isset($origin) ? $origin : $origin_;
	$radius = isset($radius) ? $radius : $radius_;
	$unit = isset($unit) ? $unit : $unit_;

	//echo getcwd() . ' vs. path: ' .$path;
	$fs = new DynamicMenu($path, $type, $e, $rec, $maxDepth, $end, $notEnd, $endMode,
						$base,
						$orderedMenu, $orderBy, $homeAlwaysAtTop,
						$menuMap, $staticEntries, $orderMode, $shortIDs,
						$circular, $origin, $radius, $unit
					);
	if (!isset($_GET['build']) || ($_GET['build'] != 'off' && $_GET['build'] != false))
	{
		$fs->lis = $fs->buildMenu();
		if ($renderMenu || ($renderMenu != 'off' && $renderMenu != false))
		{
			$fs->renderMenu();
		}
	}

}








// no includes
class DynamicMenu
		{
	// ======= Attributes
	//private $jetzt = getDate(time());
	private $dir = true;
	private $files = false;
	private $hiddenIndicators = array('.', '#');
	private $exceptions = array('dir','img','css','js','db_connect.inc.php','.','..');

	private $onlyToFirstPoint = true;  // e.g. remove .class.php from the file name
	private $recursive = false;
	private $base = '';
	private $homeDir = '';
	private $path = '';
	private $d;  // for a Directory object instance
	private $results = array();  // as storage for results - filled $results[0.Ebene]=..
	private $res = array();  // as storage for results - filled $res[]=completePath
	private $depth = 0;  // makes styling the subnavs easier #nav2 li {}
	private $maxDepth = 2;  // otherwise the performance suffers
	private $end = array();  // valid Endings
	private $notEnd = array();  // not valid Endings
	private $endMode = 'l';  // Ending Mode is last Ending
	private $navMode = false; // navMode = 'get' for using GET requests

	private $orderedMenu = true;  // whether to order the menu or not
	private $menuMap = false;  // whether a menu not exists or the $menuMap
	private $orderBy = 'filesize';  // filesize, but poss: {false|title|order(map)}
	private $homeAlwaysAtTop = true;
	private $orderMode = 'asc';  // either from great to small or the other way round
	private $shortIDs = true;  // whether to set IDs without ending
	private $circular = false;
	private $origin = ['50%', '50%'];  // decoupled from unit to allow center positioning
	private $radius = 50;
	private $unit = '%';

	private $staticEntries = array();  // static absolute or relative menu links

	private $currentMarker = false;  // to react on a current marker that may be set


	public $message = null;
	public $state = 'not busy';
	// NAV DIV
	public $toGiveBack = '<style type="text/css" href="./dynamic_menu.css"></style><div id="nav">';
	public $toGiveBack_ = '</div>';
	// NAV DIV -END






	// ======= CONSTRUCTORS
	public function __construct($hD, $type, $excs, $rec=false, $maxDepth=2,
			$end=false, $nEnd=false, $eM=false, $b=false,
			$orderedMenu=true, $orderBy='filesize', $homeAlwaysAtTop=true,
			$menuMap=false, $staticEntries=false, $orderMode='asc', $shortIDs = true,
			$circular=false, $origin=['50%','50%'], $radius=50, $unit='%'
		)
	{
		$this->path = $this->homeDir = $hD;			 // home_dir required
		if (substr($this->path, 0, 1) != '/')
			$this->base = ($b != false ? $_SERVER['DOCUMENT_ROOT'] : '');
		$this->circular = $circular;
		$this->origin = $origin;
		$this->radius = $radius;
		$this->unit = $unit;

		if (substr($this->homeDir,0,3) == '../' && sizeOf(explode('/',$this->homeDir)) == 0)
		{
			chdir($this->homeDir);
		}
		//echo 'Type: '.$type;
		//echo getcwd();
		switch ($type)
		{
			case 'dirget':
				$this->navMode = 'get';
			case 'dir':
				$this->dir = true;
				$this->files = false;
				break;
			case 'filesget':
				$this->navMode = 'get';
			case 'files':
				$this->dir = false;
				$this->files = true;
				break;
			case 'allget':
				$this->navMode = 'get';
			case 'all':
			case '':
			case null:
			case false:
			case 'everything':
			default:
				$this->dir = true;
				$this->files = true;
				break;
		}

		$this->recursive = ($rec) ? true : false;
		$this->maxDepth = intval($maxDepth);

		if (is_array($excs))
			foreach ($excs as $e)
				$this->exceptions[] = $e;
		else $this->exceptions[] = $e;
		$this->exceptions = array_unique($this->exceptions);

		$this->endMode = ($eM != false) ? $eM : 'last';
		if ($end != false)
		{
			$this->end = array('');  // ensure type array
			if (is_array($end))
				foreach ($end as $v)
					$this->end[] = $v;
			else $this->end[] = $end;
			$this->end = array_unique($this->end);
		}
		if ($nEnd != false)
		{
			$this->notEnd = array('');
			if (is_array($nEnd))
				foreach($nEnd as $v)
					$this->notEnd[] = $v;
			else $this->notEnd[] = $nEnd;
			$this->notEnd = array_unique($this->notEnd);
		}


		if (substr($this->path, 0, 1) != '/')
			$this->base = dirname(__FILE__);

		// order by and generate general query string/type-link
		$this->orderedMenu = $orderedMenu;
		$this->orderBy = $orderBy;
		$this->menuMap = $menuMap;

		$this->homeAlwaysAtTop = $homeAlwaysAtTop;
		$this->orderMode = strtolower($orderMode);
		$this->staticEntries = is_array($staticEntries) ? $staticEntries : array();
		$this->shortIDs = $shortIDs ? true : false;
	}





	//======= METHODS


	/**
	backHome (ET:)
	*/
	public function backHome()
	{
		// Create dir object for current home directory
		$this->d = dir($this->homeDir);
	}



	/**
	render
	*/
	public function render()
	{
		echo $this->toGiveBack.$this->toGiveBack_;  // make the present
	}



	/**
	getEnd
	*/
	public function getEnd($toGetEndFrom, $part = 'last')
	{
		$res = explode('.', $toGetEndFrom);
		if (count($res) == 1)
		{
			return false;
		}
		switch ($part)
		{
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



	/**
	getResults
	*/
	public function getResults()
	{
		return $this->results;
	}



	/**
	getRes
	*/
	public function getRes()
	{
		return $this->res;
	}



	/**
	getHomeDir
	*/
	public function getHomeDir()
	{
		return $this->homeDir;
	}



	/**
	getPath
	*/
	public function getPath()
	{
		return $this->path;
	}










	//======== ORDERED SHARK - EVOLVED VERSION ================================//
	########## MAIN ATTRIBUTE ###################################################
	public $lis = array();					// also contains sublevels
											// shall allow special order



	########### EVOLVED METHODS #################################################
	/**
	* generateLi
	* also need an attribute called depth to save the depth of nested menus
	* @param $title meist Datei-Name toFairy() oder mapped English Title
	* @param $pathTo Dateiname ...
	* @param $class li-Klasse(n) [optional]
	* @param innerHTML innerHTML z.B. <span>Good evening!</span> [optional]
	*/
	function generateLi($title,$pathTo,$class='nav_li',$mDir=false,$innerHTML=false)
	{
		/* sets the following array-entries:
		title | pathTo | class | file | dir | order | filesize | class | depth
		*/
		global $startEN;
		global $startDE;
		$startPages = array($startEN, $startDE);

		// static menu li to build?
		$staticCond = is_array($this->staticEntries)
			&& !empty($this->staticEntries)
			&& (isset($this->staticEntries[$title]) || in_array($pathTo,$this->staticEntries));

		// build LI
		$li['title'] = $title;

		$li['pathTo'] = $pathTo;
		$dirsAndFile = explode('/', $pathTo);
		$dirsAndFileL = count($dirsAndFile);
		$li['file'] = $dirsAndFile[$dirsAndFileL - 1];
		// Ends at directory? (no filename given)
		$li['pathTo'] = $pathTo;
		if (!is_file($pathTo))
		{
			// index?
			$d = dirname(__FILE__);
			if (file_exists($d.'/'.$pathTo.'/index.php'))
			{
				$li['file'] = 'index.php';
				$pathTo .= '/'.$li['file'];
			}
			else if (file_exists($d.'/'.$pathTo.'/index.htm'))
			{
				$li['file'] = 'index.htm';
				$pathTo .= '/'.$li['file'];
			}
			else if (file_exists($d.'/'.$pathTo.'/index.html'))
			{
				$li['file'] = 'index.html';
				$pathTo .= '/'.$li['file'];
			}
			// home?
			else if (file_exists($d.'/'.$pathTo.'/home.php'))
			{
				$li['file'] = 'home.php';
				$pathTo .= '/'.$li['file'];
			}
			else if (file_exists($d.'/'.$pathTo.'/home.htm'))
			{
				$li['file'] = 'home.htm';
				$pathTo .= '/'.$li['file'];
			}
			else if (file_exists($d.'/'.$pathTo.'/home.html'))
			{
				$li['file'] = 'home.html';
				$pathTo .= '/'.$li['file'];
			}
			else
			{
				//TODO If no file in directory? Shall we abort and not display this directory in the menu?
				//echo 'Excluding directory as no index|home.php|html|htm file was find within it:' . $pathTo;
				//return null;
				//TODO better choose next best found file? Only then return null?
				//$li['file'] = null; //<-- if '' then we get in a endless loop it seems.
				//return array("NEITHER INDEX.PHP|HTML|HTM NOR HOME.PHP|HTML|HTM FILE FOUND IN DIRECTORY: ".$d.'/'.$pathTo);
			}
			//if (isset($li['file']) && !empty($li['file']))
			//{
				$pathTo = preg_replace('/\/{2}/', '/', $pathTo);
			//}
			$pathTo = str_replace('//', '/', $pathTo);

			$dirsAndFile = explode('/', $pathTo);
			$dirsAndFileL = count($dirsAndFile);
		}
		$li['dir'] = false;
		if ($dirsAndFileL > 1)
		{
			// 2ndLast = dir becase last = filename
			$li['dir'] = $dirsAndFile[$dirsAndFileL - 2];
		}
		if (empty($li['dir']) && $mDir)
		{
			// motherDir
			$li['dir'] = $mDir;
		}
		//echo 'dir'.$li['dir'].' pathTo:'.$li['pathTo'].' file:'.$li['file']."\n";

		$li['filesize'] = intval($this->savefilesize($pathTo));
		$li['class'] = $class;

		// ORDER
		$li['order'] = 1000;
		if ($this->orderBy == 'random')
		{
			$li['order'] = mt_rand(0, 5000);
		}
		if ($this->menuMap && is_array($this->menuMap))
		{
			$li['order'] = 1000;
			$langAndTitle = getLang().'__'.$title;
			// short cuts => 1click-LanguageSwitch-AndGetCorrectPage
			if (in_array($title, $this->menuMap))
			{
				$li['order'] = array_keys($this->menuMap, $title);
				$li['order'] = $li['order'][0];
			}
			else if (in_array($langAndTitle, $this->menuMap))
			{
				$li['order'] = array_keys($this->menuMap, $langAndTitle);
				$li['order'] = $li['order'][0];
			}
			else if (isset($this->menuMap[$title]))
			{
				$li['order'] = array_keys($this->menuMap, $this->menuMap[$title]);
				$li['order'] = $li['order'][0];
			}
			else if (isset($this->menuMap[$langAndTitle]))
			{
				$li['order'] = array_keys($this->menuMap, $this->menuMap[$langAndTitle]);
				$li['order'] = $li['order'][0];
			}
			// filename with ending
			else if (in_array($li['file'], $this->menuMap))
			{
				$li['order'] = array_keys($this->menuMap, $li['file']);
				$li['order'] = $li['order'][0];
			}
			else if (isset($this->menuMap[$li['file']]))
			{
				$li['order'] = array_keys($this->menuMap, $this->menuMap[$li['file']]);
				$li['order'] = $li['order'][0];
			}
			else if (strpos($li['file'], 'index') !== false)
			{
				$menuMapPos = 0;
				foreach ($this->menuMap as $menuMapItemKey => $menuMapItem)
				{
					if (strpos($li['dir'], $menuMapItemKey) !== false
							|| strpos($li['dir'], $menuMapItem) !== false)
						$li['order'] = $menuMapPos;
					++$menuMapPos;
				}
			}
		}

		if (isset($_GET[$li['title']]))
		{
			$this->currentMarker = $li['title'];
		}
		// current - marker
		$qs = false;
		if (isset($_GET[$this->currentMarker])
			&& (!isset($_GET['type']) || empty($_GET['type'])
				|| $this->currentMarker != $li['title']) )
		{
			//echo 'reached';
			$qs = $this->rmFromQSAndAdd($this->currentMarker);
			if (isset($_GET['loc']))
			{
				$qs = $this->rmFromQSAndAdd('loc', false, false, $qs);
			}
			unset($_GET[$this->currentMarker]);
		}

		if (isset($_GET['loc']))
		{
			$qs = $this->rmFromQSAndAdd('loc', false, false, $qs);
			$qs = $this->rmFromQSAndAdd('lehre', false, false, $qs);
			$qs = $this->rmFromQSAndAdd('lectures', false, false, $qs);
			//$qs = $this->rmFromQSAndAdd('type', false, false, $qs);
		}

		// Update: recognize file as current even though html entities in filename
		global $filename;
		$id = $filename;  // id may have been derived in body.tpl.php already
		if (empty($id))
		{
			$id = self::getParamPlusHtml((
				isset($_GET['id']) ? $_GET['id'] : ""
			));
		}

		//echo ''.strtolower($id).' == '.strtolower($li['title']).' == '.strtolower($li['file']).'<br />';
		if (!empty($id) && !$staticCond
			&& (
				(strtolower($id) == strtolower($li['title']))
				|| strtolower($id) == strtolower($li['file'])
			)
			|| empty($id) && in_array($li['file'], $startPages) && !$staticCond
			|| !empty($_GET[$li['title']]) && !$staticCond
			|| !empty($_GET['type']) && !$staticCond
				&& ($_GET['type'] == $li['file'] || $_GET['type'] == $li['title'])
			)
		{
			$class .= ' current';
			//if ($li['hasChildren'])
			//{
				$class .= ' mother parent';  // in combination with current :)
			//}
		}
		if ($staticCond)
		{
			$class .= ' static';
		}
		// Update: for optional use of html-entities
		// replaces all possible chars with their corresponding html equivalents
		//$pathTo = htmlentities($pathTo);
		//$li['pathTo'] = htmlentities($li['pathTo']);

		// static menu li to build?
		if ($staticCond)
		{
			$href = $li['pathTo'];
			$titleToSet = $title;
		}
		// no static entries exist => this li needs to be dynamic
		else
		{
			$href = $this->getLiAHref($li);
			$titleToSet = self::toFairy($li['title']);
		}

		if ($this->menuMap)
		{
			// get keys as numeric and(?) string
			//$titleArK = array_keys($li['title']);
			//$fileArK = array_keys($li['file']);
			$tArVal = false;
			if (isset($this->menuMap[$li['title']]))
			{
				$tArVal = $this->menuMap[$li['title']];
			}
			$fArVal = false;
			if (isset($this->menuMap[$li['file']]))
			{
				$fArVal = $this->menuMap[$li['file']];
			}
			// TODO somehow use the above to translate and retranslate
			// Goal: Ending no longer needed.
		}

		//$href = self::addToQS('type',$li['dir'],self::addToQS('id',$li['file'],$qs));
		$li['innerHTML'] = '<a href="'  // nested addToQS call
			.self::ampersandOfHtmlEntityToHtmlEntityItself($href)
			.'" class="'.$class.'">'
			.ucfirst(html_entity_decode($titleToSet))
			.'</a>';

		if ($innerHTML)
		{
			$li['innerHTML'] = $innerHTML;
		}
		$li['outerHTML'] = '<li class="'.$class.'">'.$li['innerHTML'].'</li>';
		$li['depth'] = $this->depth;

		// gets saved to attribute in function read3
		return $li;
	}



	/**
	* getLiAHref
	* Returns the correct href-Attribute-string depending on the mode (get/direct)
	*/
	function getLiAHref($li = false)
	{
		if (!$li)
		{
			return 'no li given';
		}
		$qs = false;
		if (isset($_GET[$this->currentMarker])
			&& (!isset($_GET['type']) || empty($_GET['type'])
				|| $this->currentMarker != $li['title']) )
		{
			$qs = $this->rmFromQSAndAdd($this->currentMarker);
			//unset($_GET[$li['title']);
		}
		if (isset($_GET['loc']))
		{
			$qs = $this->rmFromQSAndAdd('loc', false, false, $qs);
			$qs = $this->rmFromQSAndAdd('lehre', false, false, $qs);
			$qs = $this->rmFromQSAndAdd('lectures', false, false, $qs);
		}
		if (isset($_GET['type'])
				&& strtolower($_GET['type']) != strtolower($li['dir']))
		{
			$qs = $this->rmFromQSAndAdd('type', false, false, $qs);
		}
		if ($this->navMode != 'get')
		{
			return $li['dir'].'/'.$li['file'];
		}
		//else
		if ($this->shortIDs)
		{
			$lif = $li['file'];

			// remove language prefix
			$parts = explode('__', $lif);
			$lang =
			$language = getLang();
			if (count($parts) > 1)
			{
				$lang = $parts[0];
				$lif = $parts[1];
			}
			if ($lang != $language)
				return;

			if (!empty(array_filter($this->end)))
			{
				foreach ($this->end as $ending)
				{
					if (empty($ending))
					{
						continue;
					}
					//echo $ending.' liFile: '.$lif.'<br />';
					$lif = preg_replace('/[.]'.$ending.'/', '', $lif);
					//echo '&nbsp;lif:'.$lif.'<br /><br />';
				}
				return self::addToQS('type',$li['dir'],self::addToQS('id',$lif,$qs));
			}
			//else
			$endings = array('php','php5','php4','html','htm','js','css',
				'jsp','txt','pdf','ps','class','java','cpp',
				'c','has','xml','xul','sql','xhtml','tex','lyx');
			foreach ($endings as $ending)
			{
				if (empty($ending))
				{
					continue;
				}
				//echo $ending.' liFile: '.$lif.'<br />';
				$lif = preg_replace('/[.]'.$ending.'/', '', $lif);
				//echo '	&nbsp;lif:'.$lif.'<br /><br />';
			}
			return self::addToQS('type',$li['dir'],self::addToQS('id',$lif,$qs));
		}
		//else
		return self::addToQS('type',$li['dir'],self::addToQS('id',$li['file'],$qs));
	}



	/**
	* orderMenu
	* @param $lis:array The array to sort.
	*/
	function orderMenu($lis = null)
	{
		global $startDE;
		global $startEN;
		if ($lis == null)
		{
			$lis = $this->lis;
		}
		if (!is_array($lis))
		{
			return $lis;
		}
		//uasort($lis, 'reorder'); own function used [see function below]

		// The string which tells which index toSort is set in configuration at the beginning.
		$schatz = array();
		$truhe = intval(0);
		$toSort = $this->orderBy or 'filesize';
		if ($this->orderBy == 'random' || $this->orderBy == 'randomMap')
		{
			$toSort = 'order';
		}
		//echo "\n<br />".'reached';
		$lisL = count($lis);  // for performance
		switch ($this->orderMode)
		{
		default :
		case 'asc':
		case 'ascending':
			// makes i.e. filesize and menuMap possible (first sorting)
			for ($i = 1; $i < $lisL; $i++)
			{
				#echo $lis[$i][$toSort];
				$schatz = $lis[$i];
				$truhe = $lis[$i][$toSort];
				// INSERTION SORT
				$j = $i - 1;
				while ($j > -1 && $lis[$j][$toSort] > $truhe)
				{
					$lis[$j + 1] = $lis[$j]; // swap
					$j--;
				}
				$lis[$j + 1] = $schatz;
			}
			// menuMap - sortiert stabil & erhaelt somit non-map El Vorsortierung
			if (is_array($this->menuMap) && $this->orderBy != 'order')
			{
				for ($i = 1; $i < $lisL; $i++)
				{
					$schatz = $lis[$i];
					$truhe = $lis[$i]['order'];
					// INSERTION SORT
					$j = $i - 1;
					while ($j > -1 && $lis[$j]['order'] > $truhe)
					{
						$lis[$j + 1] = $lis[$j];  // swap
						$j--;
					}
					$lis[$j + 1] = $schatz;
				}
			}
			break;

		case 'desc':
		case 'descending':
			// makes i.e. filesize and menuMap possible (first sorting)
			for ($i = 1; $i < $lisL; $i++)
			{
				$schatz = $lis[$i];
				$truhe = $lis[$i][$toSort];
				// INSERTION SORT
				$j = $i - 1;
				while ($j > -1 && $lis[$j][$toSort] < $truhe)
				{
					$lis[$j + 1] = $lis[$j]; // swap
					$j--;
				}
				$lis[$j + 1] = $schatz;
			}
			// menuMap - sortiert stabil & erhaelt somit non-map El Vorsortierung
			if (is_array($this->menuMap) && $this->orderBy != 'order')
			{
				for ($i = 1; $i < $lisL; $i++)
				{
					$schatz = $lis[$i];
					$truhe = $lis[$i]['order'];
					// INSERTION SORT
					$j = $i - 1;
					while ($j > -1 && $lis[$j]['order'] < $truhe)
					{
						$lis[$j + 1] = $lis[$j];  // swap
						$j--;
					}
					$lis[$j + 1] = $schatz;
				}
			}
			break;
		}

		// homeAlwaysAtTop?
		if ($this->homeAlwaysAtTop !== false && $this->homeAlwaysAtTop !== 'false'
			&& (isset($startDE) && $this->inLis($startDE, $lis)
				|| isset($startEN) && $this->inLis($startEN, $lis)
			)
			)
		{
			$homeli = false;
			// home li suchen
			// move everything at the succeding position until home li gefunden
			$schatz = $lis[0];  // store init li
			for ($i = 1; $i < $lisL; $i++)
			{
				$ili = $lis[$i];
				// filter by language
				$parts = explode('__', $ili['file']);
				$mParts = explode('__', basename($ili['pathTo']));
				$lang =
				$language = getLang();
				if (count($parts) > 1)
					$lang = $parts[0];
				else if (count($mParts) > 1)
					$lang = $mParts[0];
				//echo $lang . '!='. $language. ' '.$ili['file'].'<br>';
				if ($lang != $language)
					continue;

				// home li gefunden?
				if ($schatz['file'] != false
					&& ($schatz['file'] == $startDE || $schatz['file'] == $startEN))
				{
					$homeli = $schatz;
					break;
				}
				//else move prev li eins an i-li's index
				$lis[$i] = $schatz;
				// and $ili becomes the new prev-i-li for the next round
				$schatz = $ili;
			}
			if ($homeli)
			{
				$lis[0] = $homeli;
			}
		}
		return $lis;

	}



	/**
	* inLis
	* @param $needles Either array of needles or one needle(file to look for)
	* @param $haystack The haystack where the needle is supposed to got lost
	* @param $mode ENUM('or','and'): by default test if one needle exists
	*					(only relevant if $needles is an array)
	*/
	function inLis($needles, $haystack, $mode = 'or')
	{
//echo '<br>'."\n\r";
		if (!is_array($needles))
		{
			$needle = $needles;
			foreach ($haystack as $li)
			{
//echo $li['file'] .'=='.$needle . '<br>';
				if ($li['file'] == $needle)
				{
					return true;
				}
			}
			return false;
		}
		if ($mode == 'or')
		{
			foreach ($haystack as $li)
			{
				if (in_array($li['file'], $needles))
				{
					return true;
				}
			}
		}
		else
		{
			// mode 'and' - every needle needs to exist
			foreach ($needles as $needle)
			{
				if (!$this->inLis($needle, $haystack))
				{
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
	function reorder($a, $b)
	{
		if ($this->homeAlwaysAtTop && $this->orderBy == 'title')
		{
			switch (strtolower($a['title']))
			{
				case 'home':
				case 'index':
				case 'start':
				case 'startseite':
					return -1;
			}
			//switch
			switch (strtolower($b['title']))
			{
				case 'home':
				case 'index':
				case 'start':
				case 'startseite':
					return +1;
			}
		}
		//else further reorder
		if ($a[$this->orderBy] == $b[$this->orderBy])
		{
			return 0;
		}
		if ($a[$this->orderBy] < $b[$this->orderBy])
		{
			return -1;
		}
		return +1;
	}



	/**
	buildMenu
	dynamic menu
	EVOLVED GET-VERSION [with ORDER options]
	*/
	public function buildMenu($lis = null, $oVal='', $submenu = false, $dirfound_one_level_higher = null)
	{

		if ($lis == null)
		{
			//echo 'homeDir: ' . $this->homeDir. '<br/>';
			//echo 'base: ' . $this->base. '<br/>';
			$lis = $this->read3($this->base.(preg_replace('/[.]{1,2}\//i','',$this->homeDir)), $submenu);
		}
		$finalLis = array();
		foreach ($lis as $li)
		{
			$liEnd = $this->getEnd($li['pathTo']);
			if ($this->end != false
			&& (array_search($this->getEnd($li['pathTo'],$this->endMode),$this->end) == false)
			&& $liEnd && !empty($liEnd))
				continue;

			// filter by language
			$parts = explode('__', $li['file']);
			$mParts = explode('__', basename($li['pathTo']));
			$lang =
			$language = getLang();
			if (count($parts) > 1)
				$lang = $parts[0];
			else if (count($mParts) > 1)
				$lang = $mParts[0];
			//echo $lang . '!='. $language. ' '.$li['file'].'<br>';
			if ($lang != $language)
				continue;

			// filter by ending
			if ($this->notEnd != false
			&& array_search($this->getEnd($li['pathTo'],$this->endMode),$this->notEnd) != false)
				continue;

			$finalLis[] = $li;
		}
		//print_r($lis);
		//echo '<br /><br />';
		//print_r($finalLis);
		//echo '<br /><br /><br /><br />';

		// iterate the sorted out final lis - recursively
		$deeper = false; //<-- if one of the lis goes in recursion, we increase the global depth counter. (only once per layer)
		foreach ($finalLis as $key => $li)
		{
			//echo $key .' -> '. $li.' pathTo='.$li['pathTo'] .'<br/>';
			if ($li == null || !isset($li) || empty($li) || $li['file'] == null /*hence pathTo points to the motherDir => endless recursion*/
					|| !isset($li['pathTo']) || empty($li['pathTo']))
			{
				continue;
			}
			//print_r($li);
			// because only once per level.
			//$deeper = false;
			$dirfound = false;
			if (is_dir($this->base.'/'.$li['pathTo']))
			{
				$dirfound = $this->base.'/'.$li['pathTo'];
			}
			elseif (is_dir($this->base.(getLang()).'/'.$li['pathTo']))
			{
				$dirfound = $this->base.(getLang()).'/'.$li['pathTo'];
			}
			elseif (is_dir(dirname(__FILE__).'/'.$li['pathTo']))
			{
				$dirfound = dirname(__FILE__).'/'.$li['pathTo'];
			}
			elseif (is_dir(getLang().'/'.$li['pathTo']))
			{
				$dirfound = getLang().$li['pathTo'];
			}

			if ($dirfound_one_level_higher != null && $dirfound == $dirfound_one_level_higher)
			{
				// => avoid endless loop (it's a double)
				return null;
			}

			$li['hasChildren'] = false;
			if ($this->recursive && $dirfound !== false
				&& $this->depth < $this->maxDepth)
			{
				// if this li has reached deeper level. (currently only used globally)
				$deeper = true;
				// read3() returns $lis!
				//echo 'reached recursion: dirfound '.$dirfound;

				$finalLis[$key]['hasChildren'] = $this->buildMenu($this->read3($dirfound, $deeper), '', true, $dirfound);
				#echo 'hasChildren:';
				#print_r($li['hasChildren']);
			}
		}
		if ($deeper)
		{
			$this->depth++;
		}
		//echo 'finalLis: ';
		//print_r($finalLis);
		//echo '<br />';
		return $finalLis;
	}



	/**
	* read3
	*/
	public function read3($dirpath = false, $submenu = false)
	{
		$d = dirname(__FILE__);
		if ($dirpath)
		{
			//echo $dirpath;
			if (is_file($dirpath) && !is_dir($dirpath))
			{
				$dirpath = dirname($dirpath);
			}
			//echo $dirpath.'<br />';
			//define('BASE_PATH', realpath('.'));
			$d = $dirpath;
		}
		//echo '####'.realpath('../');
		//echo $d;
		$d = dir($d);
		//echo is_object($d) ? 'success' : 'failure';
		$lis = array();

		while (($entry = $d->read()) !== false)
		{
			$ending = $this->getEnd($entry);
			$firstChar = substr($entry, 0, 1);
			if (array_search($firstChar, $this->hiddenIndicators) !== false)
			{
				continue; #=> file shall not occur in (dynamic) menu
			}
			if (is_dir($entry)
					&& $this->dir && array_search($entry,$this->exceptions) == false
					|| !is_dir($entry) && $ending != false && $ending != ''
					&& $this->files && !array_search($entry,$this->exceptions))
			{
				//echo $entry."\n";
				//echo $this->dir ? ' true ' : ' false';
				//buildLi - $title, $pathTo, ...
				$filename = str_replace('.'.$this->getEnd($entry), '', $entry);
				#echo $filename;
				$classToSet = 'inline';
				if ($this->depth > 0)
				{
					$classToSet = 'none';
				}
				// get motherDir
				$mDir = false;
				if ($dirpath && $submenu)
				{
					$dirs = explode('/', $dirpath);
					//$mDir = $dirs[count($dirs) - 1];
					$mDirIndex = count($dirs) - 1;
					if (isset($dirs[$mDirIndex]))
					{
						$mDir = $dirs[$mDirIndex];
					}
				}
				$lis[] = $this->generateLi($filename,$entry,'nav_li '.$classToSet,$mDir);
			}
		}
		$d->close();
		// additional static menu entries
		foreach ($this->staticEntries as $ent)
		{
			if ($submenu)
			{
				break;
			}
			$parts = explode('/',$ent);
			$file = $parts[count($parts) - 1];
			$filename = str_replace('.'.$this->getEnd($file), '', $file);
			$title = $filename;
			$arK = array_keys($this->staticEntries, $ent);
			foreach ($arK as $key)
			{
				if (is_string($key))
				{
					$title = $key;
				}
			}
			$lis[] = $this->generateLi($title, $ent, 'nav_li');
		}
		// reorder menu
		if ($this->orderedMenu)
		{
			$lis = $this->orderMenu($lis);
		}
		//$this->depth++;
		//print_r($lis);
		return $lis;
	}



	/**
	* renderLevel
	* builds output recursively ..
	* if the level changes i.e. from 0 to 1, then it goes deeper
	*	and concats the resulting output-string to the parent li
	* @param $lisSub -- zu Beginn erste Ebene, dann Subarray eines $this->lis-Entry
	* @param $level -- termination condition
	*/
	function renderLevel($lisSub, $level = 0, $motherLi = false)
	{
		$out = '';
		$cToS = ' block';
		$cond = $level > 0
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
		if ($cond)
		{
			//echo 'condition: true<br /><br />';
			$cToS = 'nav_li';//display:none by default via CSS
		}
		//else echo 'cond.: false ('.$_GET['type'].')<br /><br />';
		$isChild = $motherLi !== false;
		$out .= $motherLi ? $this->getLi('', $cToS, $motherLi, $isChild).$motherLi['innerHTML'] : '';
		$out .= $this->getUl('depth'.$level, 'nav nav_ul'.$cToS, 'notype');
		$deeper = false;

		foreach ($lisSub as $li)
		{
			// If for a directory no file to be included was found (currently only index|home.php|html|htm are examined), then we not show this directory in the menu. => Directories only in menu if index.php ! Comes in handy as no prepending with . or # is necessary to exclude it. So by default a directory is not shown.
			if ($li == null || !isset($li) || empty($li))
			{
				continue;
			}
			//$out .= $cond ? $this->getLi().$li['innerHTML'] : $li['outerHTML'];
			//echo 'reached -- innerHTML: '.$li['innerHTML'].'<br />';
			//echo 'reached -- hasChildren: '.$li['hasChildren'].'<br />';

			if (isset($li['hasChildren']) && $li['hasChildren'])
			{
				//print_r($li['innerHTML']);
				// increase only once per renderLevel
				if (!$deeper)
				{
					$level++;
				}
				$deeper = true;
				//print_r($li['hasChildren']);
				$out .= $this->renderLevel($li['hasChildren'], $level, $li);
			}
			else
				$out .= $li['outerHTML'];

			//$out .= $cond ? $this->getLi_() : '';
		}

		$out .= $this->getUl_();
		$out .= $motherLi ? $this->getLi_() : '';

		return $out;
	}



	/**
	* renderMenu
	* finally 'outputs' the dynamic menu
	*/
	function renderMenu()
	{
		$out = $this->renderLevel($this->lis)
		.'<style type="text/css">/*<[CDATA[*/'."\n"
			.'/*better twice than not at all*/'."\n"
			.'.none { display: none !important; }'."\n"
			.'.inline,.static { display: block; }'."\n"
			;
		$circularCss = '';
		if ($this->circular)
		{
			// arrange elements circularly
			$lisL = count($this->lis);
			$angle_step = 2 * M_PI / $lisL;
			for ($i = 0; $i < $lisL; ++$i)
			{
				$angle = $i * $angle_step;
				$circularCss .= '.nav_ul > li:nth-child('. ($i + 1) .')'
					. '{' . "\n"
					. 'margin-left: '. ($this->radius * cos($angle)) . $this->unit . ';'
					. 'margin-top: '. ($this->radius * sin($angle)) . $this->unit . ';'
					. 'left: ' . $this->origin[0] . ';'
					. 'top: ' . $this->origin[1] . ';'
					. '}' . "\n"
				;
			}
		}
		$out_ = '/*]]>*/</style>';
		echo $out . $circularCss . $out_;
	}







	//======= HELPER
	/**
	* toFairy
	*/
	static function toFairy($string)
	{
		if (!is_string($string))
			''.$string.'';
		$string = trim($string);
		$string .= ' ';
		$beforePoint = explode('.', $string);

		$remain = explode('__', $beforePoint[0]);
		if (count($remain) > 1)
		{
			$lang = $remain[0];
			$remain = $remain[1];
		}
		else
			$remain = $remain[0];

		$remain = explode('_', $remain);

		// more universal approach
		$s = $remain[0];
		$fairy = strtoupper($s[0]).substr($s, 1);
		for ($i = 1; $i < count($remain); $i++)
		{
			$word = $remain[$i];
			if (empty($word))
				continue;
			$fairy .= ' '.strtoupper($word[0]).substr($word.' ', 1, strlen($word) - 1);
		}
		return $fairy;
	}



	/**
	* savefilesize
	* @param $file path to file to get size from
	* @return filesize, if file exists [unit: Bytes]
	* '-'	 , otherwise
	*/
	public function savefilesize($file)
	{
		if (file_exists($file))
		{
			return filesize($file).' B';
		}
		return '0 Bytes';
	}



	/**
	* getUl
	* returns the begin tag of an ul tag
	*/
	function getUl($id = '', $class = '', $type = '')
	{
		return '<ul id="'.$id.'" class="'.$class.' ' .$id. '" type="'.$type.'">';
	}

	/**
	* getUl_
	* returns the end tag of an ul tag
	*/
	function getUl_()
	{
		return '</ul>'."\n";
	}



	/**
	* getLi
	* returns the begin tag of an li tag
	*/
	function getLi($id = '', $class = 'nav_li', $li, $isChild = false)
	{
		// to avoid problems if there was no page id set
		global $startEN;
		global $startDE;
		$startPages = array($startEN, $startDE);

		// current - marker
		if (isset($_GET['id'])
			&& (
				(strtolower($_GET['id']) == strtolower($li['title']))
				||
				strtolower($_GET['id']) == strtolower($li['file'])
			)
			|| !isset($_GET['id']) && in_array($li['file'], $startPages) && !$isChild
		)
		{
			$class .= ' current';
		}
		return '<li id="'.$id.'" class="'.$class.'">';
	}

	/**
	* getLi_
	* returns the end tag of an li tag
	*/
	function getLi_()
	{
		return '</li>';
	}



	/**
	* addToQS
	*/
	public static function addToQS($param, $value, $qs = false)
	{
		if ($qs)
		{
			$qs = str_replace('?', '', $qs); //das ? am Anfang des Strings entfernen
		}
		elseif (!$qs)
		{
			$qs = $_SERVER['QUERY_STRING'];
		}
		#$qs =	str_replace('&amp;', '&', $qs); //um htmlentities zu ermoeglichen

		if (empty($value))
		{
			return '?'.$qs;
		}

		if (strlen($qs) == 0)
		{
			return '?'.$param.'='.$value;
		}
		else if (strpos($qs, $param) === FALSE)
		{
			return '?'.$qs.'&'.$param.'='.$value;
		}
		//else
		$valueRegex = '[a-zA-Z0-9+-_%~.]*([&]amp[;][#]?[a-zA-Z0-9]+[;])?([.]{0,1}[a-zA-Z]+)*';
		$qs = '?'.preg_replace('/'.$param.'='.$valueRegex.'/i',$param.'='.$value,$qs);
		$qs = str_replace('&&','&', $qs);
		$qs = preg_replace('/&$/','', $qs);
		$qs = str_replace('type=&','', $qs);
		$qs = preg_replace('/[&]type[=]$/','', $qs);
		return str_replace('??', '?', $qs);
	}



	/**
	* rmFromQSandAdd
	* Entfernt 1 GET Parameter und fuegt 1 GET Parameter hinzu, bzw. ersetzt !
	* @param $nameToRemove -- Variablen-Name des zu entfernenden Parameters
	* @param $name		 -- Variablen-Name des zu setzenden Parameters
	* @param $val			-- Variablen-Wert des zu setzenden GET-Parameters
	*/
	function rmFromQSandAdd($nameToRemove, $name = false, $val = false, $qs = false)
	{
		if (!$qs)
		{
			$qs = $_SERVER['QUERY_STRING'];
		}
		// remove if set parameter $nameToRemove
		$valueRegex = '[a-zA-Z0-9+-_%~.]+([.]?[a-zA-Z]+)*';
		$qs = preg_replace('/'.$nameToRemove.'='.$valueRegex.'[&]?/', '', $qs);

		$qs = str_replace($nameToRemove.'=&','', $qs);
		$qs = preg_replace('/'.$nameToRemove.'=$/i', '', $qs);
		if (!$name)
		{
			return '?'.$qs;
		}

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
	static function ampersandOfHtmlEntityToHtmlEntityItself($urlPart)
	{
		$urlPartNew = '';
		$urlPartL = strlen($urlPart);	#FileName's length
		$pos = 0;
		//velocity boost (? i doubt it would be)
		//if (strpos('&', $urlPart) == -1)
		//{
		//	return $urlPart;
		//}
		while ($pos < $urlPartL)
		{

			$charAtPos = substr($urlPart, $pos, 1);

			if ($charAtPos != '&')
			{
				$urlPartNew .= $charAtPos;
				$pos ++;
				continue;
			}

			//else: Is there a semicolon coming before another ampersand arrives at the moon?
			// The chars following and the posChar (inclusive) for further investigation
			$urlPartPart = substr(strtolower($urlPart), $pos);

			// Is this ampersand the beginning of a html-entity?
			$isHtmlEntity = self::isSemicolonFollowingBeforeNextAmpersand($urlPartPart);

			$urlPartNew .= $charAtPos;
			if ($isHtmlEntity)
			{
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
	* @return true			-- falls html Entitaet am Wortanfang
	*		 false		 -- andernfalls (fuer Gleichberechtigung:)
	*/
	static function isSemicolonFollowingBeforeNextAmpersand($toInvestigate)
	{
		return preg_match('/^&[^&]+[;]{1}.*/i', $toInvestigate);
	}


	/**
	* getSignsTillNextChar
	* Extrahiert einen Teil einer Zeichenkette bis zum Aufkommen eines bestimmten
	* Terminierzeichens. Exklusive diesem.
	* @param $haystack -- die Zeichenkette
	* @param $char	 -- das Zeichen bis zu dem die Zeichenkette zu extrahieren ist
	* @param $offset	-- der Zeichenketten-Index, ab dem zu suchen
	*/
	static function getSignsTillNextChar($haystack, $char = ';', $offset = 0)
	{
		// extract from Offset till the end
		$hay = substr($haystack, $offset);
		$hayL = strlen($hay);

		$extracted = '';
		$pos = -1;
		$actuallyInvestigated = '';
		while (++$pos < $hayL)
		{
			$actuallyInvestigated = substr($hay, $pos, 1);
			if ($actuallyInvestigated == $char)
			{
				break;
			}
			$extracted .= $actuallyInvestigated;
		}
		if ($extracted == $hay)
		{
			// No such termination char found.
			return '';//false;
		}
		return $extracted;
	}



	/**
	* getIdPlusHtml
	* Falls sich HTML-Entititaeten hinter dem Wert eines $_GET-Parameters	befinden,
	* so werden diese noch zu dem Wert des vorangegangenen Parameters dazugezaehlt.
	* @param $GETParam	-- Inhalt einer super globalen Variable $_GET['param']
	*/
	static function getParamPlusHtml($GETParam)
	{
		$GETParamPlusHtml = $GETParam;
		$valueRegex = '/'.$GETParam.'&amp;[#]?[a-zA-Z0-9]+;/';
		if (preg_match($valueRegex, $_SERVER['QUERY_STRING']))
		{
			$beginIdAmpIndex = strpos($_SERVER['QUERY_STRING'], $GETParam.'&amp;');
			$offset = $beginIdAmpIndex + strlen($GETParam) + strlen('&amp;');
			$teddy = '&';
			$GETParamPlusHtml .= '&amp;'.self::getSignsTillNextChar(
					$_SERVER['QUERY_STRING'], $teddy, $offset
			);
		}
		return $GETParamPlusHtml;
	}



};

?>
