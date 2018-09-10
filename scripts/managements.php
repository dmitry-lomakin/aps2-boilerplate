<?php

require "aps/2/runtime.php";

/**
* Class management
* @type("https://github.com/for93t/aps2-boilerplate/management/1.0")
* @implements("http://aps-standard.org/types/core/subscription/service/1.0")
*/

class management extends \APS\ResourceBase
{
	/**
	* @link("https://github.com/for93t/aps2-boilerplate/app/1.0")
	* @required
	*/
	public $app;

	/**
	 * @link("https://github.com/for93t/aps2-boilerplate/vps/1.0[]")
	 */
	public $vpses;
	
}
