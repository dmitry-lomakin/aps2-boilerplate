<?php

defined('APS_DEVELOPMENT_MODE') or define('APS_DEVELOPMENT_MODE', 'on');

require "aps/2/runtime.php";

/**
 * Class management
 * @type("http://for93t.github.com/aps2-boilerplate/management/1.0")
 * @implements("http://aps-standard.org/types/core/subscription/service/1.0")
 * @implements("http://aps-standard.org/types/core/suspendable/1.0")
 */

class management extends \APS\ResourceBase
{
	/**
	* @link("http://for93t.github.com/aps2-boilerplate/app/1.0")
	* @required
	*/
	public $app;

	/**
	 * @link("http://for93t.github.com/aps2-boilerplate/vps/1.0[]")
	 */
	public $vpses;

    /**
     * @verb(PUT)
     * @path("/enable")
     * @access(admin, true)
     * @access(owner, true)
     * @access(referrer, true)
     *
     * @return void
     */
    public function enable()
    {
        $logger = \APS\LoggerRegistry::get();
        $logger->setLogFile(__DIR__ . "/logs/messages.log");
        $logger->info(__METHOD__ . ': ' . print_r($this->vpses, true));
    }

    /**
     * @verb(PUT)
     * @path("/disable")
     * @access(admin, true)
     * @access(owner, true)
     * @access(referrer, true)
     *
     * @return void
     */
    public function disable()
    {
        $logger = \APS\LoggerRegistry::get();
        $logger->setLogFile(__DIR__ . "/logs/messages.log");
        $logger->info(__METHOD__ . ': ' . print_r($this->vpses, true));
    }
	
}
