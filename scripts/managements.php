<?php

require "aps/2/runtime.php";

/**
 * Class management
 *
 * @property \APS\ResourceProxy $subscription
 *
 * @type("http://for93t.github.com/aps2-boilerplate/management/2.0")
 * @implements("http://aps-standard.org/types/core/subscription/service/1.0")
 * @implements("http://aps-standard.org/types/core/resource/1.0")
 */

class management extends \APS\ResourceBase
{
	/**
	* @link("http://for93t.github.com/aps2-boilerplate/app/1.0")
	* @required
	*/
	public $app;

    /**
     * @link("http://for93t.github.com/aps2-boilerplate/offer/1.0")
     * @required
     */
    public $offer;

    /**
	 * @link("http://for93t.github.com/aps2-boilerplate/vps/3.0[]")
	 */
	public $vpses;

    /**
     * @throws Exception
     */
    public function provision()
    {
        $this->log("Starting", __METHOD__);
        $this->log("Provisioning VPS services for subscription ("
            . print_r($this->subscription->getBaseResource(), true) . ")",
            __METHOD__
        );

        $onSubscriptionChanged = new \APS\EventSubscription(
            \APS\EventSubscription::SubscriptionLimitChanged,
            "onSubscriptionChanged"
        );
        $onSubscriptionChanged->source = $this->subscription->aps->id;

        $this->log("Stopping", __METHOD__);
    }

    /**
     * @verb(POST)
     * @path("/onSubscriptionChanged")
     * @param("http://aps-standard.org/types/core/resource/1.0#Notification",body)
     *
     * @throws Exception
     */
    public function onSubscriptionChanged($event)
    {
        $this->log("Starting", __METHOD__);

        $this->log("The subscription has been changed to ("
            . print_r($this->subscription->getBaseResource(), true) . "), "
            . "(event = " . print_r($event, true) . ")",
            __METHOD__);

        $this->log("Stopping", __METHOD__);
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
}
