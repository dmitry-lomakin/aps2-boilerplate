<?php

require "aps/2/runtime.php";

/**
* Class management
 *
 * @property \APS\ResourceProxy $subscription
 * @property \APS\ResourceProxy $account
 *
 * @type("http://for93t.github.com/aps2-boilerplate/management/2.0")
 *
 * @implements("http://aps-standard.org/types/core/subscription/service/1.0")
 * @implements("http://aps-standard.org/types/core/resource/1.0")
 * @implements("http://aps-standard.org/types/core/subscription/migratable/1.0")
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
     * @param null $management
     */
    public function configure($management = null)
    {
        $this->log("Starting", __METHOD__);
        $this->log("Configuring management (" . print_r($management, true) . ")", __METHOD__);
        $this->log("Stopping", __METHOD__);
    }

    /**
     * @throws Exception
     */
    public function provision()
    {
        $this->log("Starting", __METHOD__);
        $this->log("Provisioning VPS services for subscription ("
            . print_r($this->subscription, true)
            . ") that belongs to the account ("
            . print_r($this->account, true) . ")",
            __METHOD__
        );

        $onAccountLinked = new \APS\EventSubscription(\APS\EventSubscription::Linked,"onAccountLinked");
        $onAccountLinked->source = new stdClass;
        $onAccountLinked->source->type = "http://aps-standard.org/types/core/account/1.0";
        \APS\Request::getController()->subscribe($this->subscription->getBaseResource(), $onAccountLinked);


        $this->log("Stopping", __METHOD__);
    }

    public function unprovision()
    {
        $this->log("Starting", __METHOD__);
        $this->log("Unprovisioning VPS services from subscription ("
            . print_r($this->subscription, true)
            . ") that belongs to the account ("
            . print_r($this->account, true) . ")",
            __METHOD__);
        $this->log("Stopping", __METHOD__);
    }

    public function retrieve()
    {
        $this->log("Starting", __METHOD__);
        $this->log("Retrieving data for management (" . print_r($this, true) . ")", __METHOD__);
        $this->log("Stopping", __METHOD__);
    }

    /**
     * @verb(POST)
     * @path("/migrationPreCheck")
     */
    public function migrationPreCheck()
    {
        $result = new stdClass;
        $result->canMigrate = true;
        $result->message = "";

        return $result;
    }

    /**
     * @param $message
     * @param string $module
     */
    protected function log($message, $module = __METHOD__)
    {
        /** @var \APS\Logger $logger */
        try {
            $logger = \APS\LoggerRegistry::get();
            $logger->setLogFile(__DIR__ . "/logs/messages.log");
            $logger->info($module . ': ' . $message);
        } catch (\Exception $e) {
            error_log($module . ': ' . $message);
            error_log($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @verb(POST)
     * @path("/onAccountLinked")
     * @param("http://aps-standard.org/types/core/resource/1.0#Notification",body)
     *
     * @throws Exception
     */
    public function onAccountLinked($event)
    {
        $this->log("Starting", __METHOD__);

        $this->log("The subscription has been transferred from this account ("
            . print_r($this->account, true)
            . ") to this account ("
            . print_r($event->source, true) . ")",
            __METHOD__);

        $this->log("Stopping", __METHOD__);
    }
}
