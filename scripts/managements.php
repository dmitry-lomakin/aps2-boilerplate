<?php

require "aps/2/runtime.php";

/**
* Class management
* @type("http://for93t.github.com/aps2-boilerplate/management/1.0")
* @implements("http://aps-standard.org/types/core/subscription/service/1.0")
*/

class management extends \APS\ResourceBase
{
	/**
	* @link("http://for93t.github.com/aps2-boilerplate/app/1.0")
	* @required
	*/
	public $app;

	/**
	 * @link("http://for93t.github.com/aps2-boilerplate/vps/2.1[]")
	 */
	public $vpses;
	
}
