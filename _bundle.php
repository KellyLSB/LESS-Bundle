<?php

namespace Bundles\LESS;
use Bundles\SQL\SQLBundle;
use Exception;
use e;

/**
 * Less compiler bundle
 */
class Bundle extends SQLBundle {

	public function __callBundle($file) {
		require_once(__DIR__ . '/library/lessc.inc.php');
		$cfile = e::$cache->path('less') . '/' . md5($file) . '.css';
		lessc::ccompile($file, $cfile);
		return $cfile;
	}

	/**
	 * Compile a string of LESS
	 * @author Kelly Becker
	 */
	public function string($string = false) {
		require_once(__DIR__ . '/library/lessc.inc.php');
		if(empty($string)) return false;

		/**
		 * Compile a string
		 * NOTE: We are not instantiating the class constructor
		 */
		return lessc::scompile($string)->parse();
	}

	/**
	 * Allow getting less via slug
	 * @author Kelly Becker
	 */
	public function getLess($slug) {
		if(!is_string($slug))
			return parent::getLess($slug);
		
		$row = e::$sql->select('theming.less', "WHERE `slug` = '$slug'")->row();
		if(!$row) return $this->newLess();
		else return parent::getLess($row);
	}

}