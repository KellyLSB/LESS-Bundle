<?php

namespace Bundles\LESS;
use Bundles\SQL\SQLBundle;
use Exception;
use e;

/**
 * Less compiler bundle
 */
class Bundle extends SQLBundle {

	public function __callBundle($file, $contents = false) {
		// Get the cached filename
		$cacheFile = e::$cache->path('less') . '/' . md5($file) . '.css';

		/**
		 * If the file is newer re-cache it
		 */
		if(filemtime($file) > filemtime($cacheFile)) {
			require_once(__DIR__ . '/library/lessc.inc.php');
			lessc::ccompile($file, $cacheFile);
		}

		// Return the file contents
		return $contents ? file_get_contents($cacheFile) : $cacheFile;
	}

	/**
	 * Compile a string of LESS
	 * @author Kelly Becker
	 */
	public function string($string = false) {
		if(empty($string)) return false;

		// Load in the compiler
		require_once(__DIR__ . '/library/lessc.inc.php');

		/**
		 * Compile a string
		 * NOTE: We are not instantiating the class constructor
		 */
		return lessc::scompile($string)->parse();
	}

	/**
	 * Compile a LESS file
	 * @author Kelly Becker
	 */
	public function file($file = fale) {
		if(empty($file)) return false;

		// Compile the file
		return $this->__callBundle($file, true);
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