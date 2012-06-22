<?php

namespace Bundles\LHTML\Nodes;
use Bundles\LHTML\Node;
use Exception;
use e;

/**
 * LHTML <:style> tag
 * @author Kelly Becker
 */
class Style extends Node {

	/**
	 * Process when the node is ready
	 * @author Kelly Becker
	 */
	public function afterReady() {		
		$this->element = 'style';

		$children = array();
		foreach($this->children as $child) {
			if(empty($child) || !is_string($child))
				continue;

			$children[] = e::$less->string($child);
		} $this->children = $children;

		$head = $this->findChildOfParent('head');
		$this->detach();

		$this->appendTo($head);
	}
	
}