<?php

/**
 * Copyright © 2017 PT Kemana Teknologi Solusi. All rights reserved.
 * http://www.kemana.com
 */

/**
 * @category Training2
 * @package  Training2_Specific404Page
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 *
 * @author   Kemana Team
 *
 */
 
namespace Training2\Specific404Page\Router;

class NoRouteHandler implements \Magento\Framework\App\Router\NoRouteHandlerInterface
{
    /**
     * @param \Magento\Framework\App\RequestInterface $request
     * @return bool
     */
    public function process(\Magento\Framework\App\RequestInterface $request)
    {
        $pathInfo = explode('/', ltrim($request->getPathInfo(), '/'));

        /* Not found product */
        if ($pathInfo[0] == 'catalog' && $pathInfo[1] == 'product' && $pathInfo[2] == 'view' && $pathInfo[3] == 'id') {
            $request->setModuleName('custom404')
                ->setControllerName('product')
                ->setActionName('index');
            return true;
        }
        
        /* Not found category */
        if ($pathInfo[0] == 'catalog' && $pathInfo[1] == 'category' && $pathInfo[2] == 'view' && $pathInfo[3] == 'id') {
            $request->setModuleName('custom404')
                ->setControllerName('category')
                ->setActionName('index');
            return true;
        }
        
        /* Not found other page */
        
        $request->setModuleName('custom404')
                ->setControllerName('other')
                ->setActionName('index');
        return true;
    }
}
