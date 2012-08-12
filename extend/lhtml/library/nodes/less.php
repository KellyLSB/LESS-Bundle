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

		if(!isset($this->attributes['slug']) && !isset($this->attributes['file']))
			throw new Exception("Must define attribute `slug` or `file` on `&lt;:less&gt;`");

		if(isset($this->attributes['slug'])) {
			$slug = $this->attributes['slug'];
			$this->children = array(e::$less->getLess($slug)->compiled);
		}

		if(isset($this->attributes['file'])) {
			$file = $this->attributes['file'];

			if(substr($file, 0, 1) !== '/')
				$file = EvolutionSite.'/static/'.$file;

			$this->children = array(file_get_contents(e::less($file)));
		}

		$head = $this->findChildOfParent('head');
		$this->detach();

		$this->appendTo($head);
	}
	
}