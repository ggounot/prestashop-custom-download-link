<?php

class ProductDownload extends ProductDownloadCore
{
    /** @var string CustomLink custom URL to the content */
    public $custom_link;

    public function __construct($id_product_download = null)
    {
        self::$definition['fields']['custom_link'] = array('type' => self::TYPE_STRING, 'validate' => 'isUrl', 'size' => 2048);
        parent::__construct($id_product_download);
    }
}
