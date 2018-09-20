<?php

require "aps/2/runtime.php";

/**
 * Class app presents application and its global parameters
 * @type("http://for93t.github.com/aps2-boilerplate/app/1.0")
 * @implements("http://aps-standard.org/types/core/application/1.0")
 * @implements("http://odin.com/init-wizard/config/1.0")
 */
class app extends APS\ResourceBase
{
    /**
     * @link("http://for93t.github.com/aps2-boilerplate/offer/2.0[]")
     */
    public $offers;

    /**
     * @link("http://for93t.github.com/aps2-boilerplate/management/2.0[]")
     */
    public $managements;

    /**
     * @type(string)
     * @title("Cloud API hostname")
     * @description("Cloud management server IP or domain name.")
     */
    public $cloudHostname;

    /**
     * @type(string)
     * @title("Username")
     * @description("Cloud administrator login")
     */
    public $cloudUsername;

    /**
     * @type(string)
     * @title("Password")
     * @description("Cloud administrator password")
     * @encrypted
     */
    public $cloudPassword;

    /**
     * @type(string)
     * @title("Customer name")
     * @description("Cloud customer name")
     */
    public $cloudCustomerName;

    /**
     * @verb(GET)
     * @path("/getInitWizardConfig")
     * @access(admin, true)
     * @access(owner, true)
     * @access(referrer, true)
     *
     * @return string
     */
    public function getInitWizardConfig()
    {
        $wizardFile = __DIR__ . '/wizard_data.json';
        $myfile = fopen($wizardFile, "r")
            or die("Unable to open file!");
        $data = fread($myfile, filesize($wizardFile));
        fclose($myfile);

        return json_decode($data);
    }

    /**
     * @verb(GET)
     * @path("/testConnection")
     * @param(object,body)
     * @access(admin, true)
     * @access(owner, true)
     * @access(referrer, true)
     *
     * @return string
     */
    public function testConnection()
    {
        return "";
    }

}
