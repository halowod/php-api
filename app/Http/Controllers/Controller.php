<?php

namespace Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;


/**
 * 
 */
class Controller extends BaseController
{
    
    public function __construct()
    {
        $this->setHeader();
    }
    
    /**
     * 设置header头信息
     */
    protected function setHeader()
    {
        
    }
}
