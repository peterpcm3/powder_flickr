<?php

namespace App\Controller;

use App\Model\Flickr;
use Lib\Template\Template;

/**
 * @brief   List all images
 */
class ListController
{
    /**
     * @brief   Create instance of list controller
     */
    public function __construct()
    {
    }
    
    /**
     * @brief   Show index page with base data
     * 
     * @return
     */
    public function indexAction()
    {
        $template   = new Template();
        $template->renderFile(TEMPLATE_DIR . 'index.php');
    }
    
    /**
     * @brief   Get list of images in json
     * 
     * @return  string
     */
    public function ajaxAction()
    {
        $products   = new Flickr();
        $data       = $products->getList();
        
        $template   = new Template();
        $template->renderFile(TEMPLATE_DIR . 'list.php', $data);
    }
}