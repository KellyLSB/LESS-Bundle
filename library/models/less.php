<?php

namespace Bundles\LESS\Models;
use Bundles\SQL\Model;
use Exception;
use e;

/**
 * Page model
 * @author Kelly Becker
 */
class Less extends Model {

	/**
	 * Compile LESS on save
	 */
	public function save() {

		/**
		 * Compile the LESS
		 */
		if(!empty($this->uncompiled))
			$this->compiled = e::$less->string($this->uncompiled);

		/**
		 * Save for reals
		 */
		return call_user_func_array('parent::save', func_get_args());
	}

}