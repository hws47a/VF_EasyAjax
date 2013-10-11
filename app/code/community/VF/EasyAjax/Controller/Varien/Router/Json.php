<?php

class VF_EasyAjax_Controller_Varien_Router_Json extends Mage_Core_Controller_Varien_Router_Standard
{
    /**
     * Collect routes
     *
     * @param $configArea
     * @param $useRouterName
     */
    public function collectRoutes($configArea, $useRouterName)
    {
        parent::collectRoutes($configArea, 'standard');
    }

    /**
     * Match with router
     *
     * @param Zend_Controller_Request_Http $request
     * @return boolean
     */
    public function match(Zend_Controller_Request_Http $request)
    {
        $path = trim($request->getPathInfo(), '/');

        if (strrpos($path, '.json') === strlen($path) - 5) {
            $request->setPathInfo(substr($path, 0, strlen($path) - 5));
            Mage::getSingleton('easyAjax/core')->setEasyAjax(true);

            return parent::match($request);
        }

        return false;
    }
}