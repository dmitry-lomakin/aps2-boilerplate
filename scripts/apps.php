<?php

require "aps/2/runtime.php";

/**
 * Class app presents application and its global parameters
 * @type("https://github.com/for93t/aps2-boilerplate/app/1.0")
 * @implements("http://aps-standard.org/types/core/application/1.0","http://odin.com/init-wizard/config/1.0")
 */
class app extends APS\ResourceBase
{
    /**
     * @link("https://github.com/for93t/aps2-boilerplate/management/1.0[]")
     */
    public $managements;

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
