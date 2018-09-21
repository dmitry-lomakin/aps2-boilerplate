<?php

require "aps/2/runtime.php";

/**
 * @type("http://for93t.github.com/aps2-boilerplate/vps/3.0")
 * @implements("http://aps-standard.org/types/core/resource/1.0")
 */
class vps extends APS\ResourceBase
{
    /**
     * @link("http://for93t.github.com/aps2-boilerplate/management/3.0")
     * @required
     */
    public $management;

    /**
     * @type("string")
     * @title("name")
     * @description("Server Name")
     */
    public $name;

    /**
     * @type("string")
     * @title("OS")
     * @description("Operating System")
     */
    public $os;

    /**
     * @param null $input
     */
    public function configure($input)
    {
        $this->log("Starting", __METHOD__);
        $this->log("Configuring a VPS (input: " . print_r($input, true) . ")", __METHOD__);
        $this->log("Stopping", __METHOD__);
    }

    /**
     * @throws Exception
     */
    public function provision()
    {
        $this->log("Starting", __METHOD__);
        $this->log("Provisioning a VPS service (offer="
            . print_r($this->offer, true) . ")",
            __METHOD__
        );
        $this->log("Stopping", __METHOD__);
    }

    public function unprovision()
    {
        $this->log("Starting", __METHOD__);
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
