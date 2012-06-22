<?php

namespace Bundles\LHTML\Nodes;
use Bundles\LHTML\Node;
use Exception;
use e;

/**
 * LHTML <:less> tag
 * @author Kelly Becker
 */
class Less extends Node {

	/**
	 * Process when the node is ready
	 * @author Kelly Becker
	 */
	public function afterReady() {		
		$this->element = 'style';

		if(!isset($this->attributes['slug']))
			throw new Exception("Must define attribute `slug` on `&lt;:less&gt;`");

		$slug = $this->attributes['slug'];
		$this->children = array(e::$less->getLess($slug)->compiled);

		$head = $this->findChildOfParent('head');
		$this->detach();

		$this->appendTo($head);
	}
	
}