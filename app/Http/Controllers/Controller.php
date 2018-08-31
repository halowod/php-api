<?php

namespace Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Routing\ResponseFactory;


/**
 * parent class
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
        $header['Content-type'] = 'text/html; charset=utf-8';
        $header['Access-Control-Allow-Origin'] = '*';
        $header['Access-Control-Allow-Methods'] = 'GET,HEAD,PUT,POST,DELETE,PATCH,OPTIONS';
        
        foreach ($header as $key => $value) {
            header("{$key}: {$value}");
        }
    }
    
    
}
