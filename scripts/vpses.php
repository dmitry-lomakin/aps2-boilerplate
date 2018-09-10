<?php

require "aps/2/runtime.php";

/**
 * @type("https://github.com/for93t/aps2-boilerplate/vps/1.0")
 * @implements("http://aps-standard.org/types/core/resource/1.0")
 */
class vps extends APS\ResourceBase
{
    /**
     * @link("https://github.com/for93t/aps2-boilerplate/management/1.0")
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

}
