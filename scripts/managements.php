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

	static private $validOfferApsTypes = array(
	    'http://for93t.github.com/aps2-boilerplate/offer/1.0',
    );

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
        $onSubscriptionChanged->source = new stdClass;
        $onSubscriptionChanged->source->id = $this->subscription->aps->id;
        \APS\Request::getController()->subscribe($this, $onSubscriptionChanged);

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
        $this->log("The event descriptor is: " . print_r($event, true), __METHOD__);

        $this->log("Finding out the subscription aps.id ...", __METHOD__);
        if (empty($event->source->id)) {
            throw new \Exception(
                "Can not get the subscription aps.id; it was supposed to be found in \$event->source->id"
            );
        }

        $subscriptionApsId = $event->source->id;
        $this->log("The subscription aps.id is found - {$subscriptionApsId}", __METHOD__);

        $this->log("Retrieving the subscription resources", __METHOD__);

        $apsController = \APS\Request::getController();
        $subscriptionResources = $apsController->getResources(
            '',
            $apsController->getIo()->resourcePath() . "/aps/2/resources/{$subscriptionApsId}/resources"
        );

        if (empty($subscriptionResources) || !is_array($subscriptionResources)) {
            throw new \Exception(
                "Can not retrieve the subscription's resources to detect current offer parameters"
            );
        }

        $offerApsId = null;
        foreach ($subscriptionResources as $eachResource) {
            if (in_array($eachResource->type, self::$validOfferApsTypes)) {
                $offerApsId = $eachResource->apsId;

                break;
            }
        }

        if (null === $offerApsId) {
            $this->log("The subscription's resources (" . print_r($subscriptionResources, true)
                . ") don't contain any reference to the offer ()", __METHOD__);
            throw new \Exception(
                "Unable to find a reference to the new subscription's offer"
            );
        }

        $this->log(
            "The offer aps.id is found ({$offerApsId}); continue to it's full resource",
            __METHOD__
        );

        $offerResource = $apsController->getResource($offerApsId);

        if (! $offerResource) {
            throw new \Exception(
                "Unable to get the offer resource"
            );
        }

        $this->log(
            "The offer descriptor is found, let's update the reference to it",
            __METHOD__);

        $offerLinkingResult = $apsController->linkResource($this, 'offer', $offerResource);
        if (! $offerLinkingResult) {
            throw new \Exception(
                "Failed to update the link to the offer (" . print_r($offerLinkingResult, true) . ")"
            );
        }

        $this->log(
            "The offer has been updated: " . print_r($offerLinkingResult, true),
            __METHOD__
        );
        $this->log("Stopping", __METHOD__);
    }

    public function offerLink($offer)
    {
        $this->log("Calling with the following argument: " . print_r($offer), __METHOD__);
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
