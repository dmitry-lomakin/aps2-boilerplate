<?php

require "aps/2/runtime.php";

class Product
{
    const TYPE_SERVER = 'server';
    const TYPE_WORKSTATION = 'workstation';

    /**
     * @type("string")
     * @title("Type")
     * @description("Backup device type")
     *
     * @option("server","Server")
     * @option("workstation","Workstation")
     */
    public $type;

    /**
     * @type("string")
     * @title("Product name")
     * @description("The name of the product to use on the backup device")
     */
    public $name;
}

/**
 * @type("http://for93t.github.com/aps2-boilerplate/offer/1.0")
 * @implements("http://aps-standard.org/types/core/resource/1.0")
 * @implements("http://aps-standard.org/types/core/profile/service/1.0")
 */
class offer extends \APS\ResourceBase
{
    /**
     * @link("http://for93t.github.com/aps2-boilerplate/app/1.0")
     * @required
     */
    public $app;

    /**
     * @link("http://for93t.github.com/aps2-boilerplate/vps/3.0[]")
     */
    public $vpses;

    /**
     * @type(string)
     * @title("Offer Description")
     */
    public $description;

    /**
     * @type("Product")
     * @title("Product")
     * @description("Product descriptor")
     */
    public $product;

}
