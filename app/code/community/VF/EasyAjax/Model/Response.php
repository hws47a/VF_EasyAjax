<?php
/**
 * Vladimir Fishchenko extension for Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * 
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade
 * the VF EasyAjax module to newer versions in the future.
 * If you wish to customize the VF EasyAjax module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   VF
 * @package    VF_EasyAjax
 * @copyright  Copyright (C) 2012 Vladimir Fishchenko (http://fishchenko.com/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Special response model
 *
 * @category   VF
 * @package    VF_EasyAjax
 * @subpackage Model
 * @author     Vladimir Fishchenko <vladimir@fishchenko.com>
 */
class VF_EasyAjax_Model_Response extends Varien_Object
{
    /**
     * @var Zend_Controller_Response_Http
     */
    protected $_response;

    /**
     * Send response to browser with json content type
     */
    public function sendResponse()
    {
        $this->_response = Mage::app()->getResponse();

        //check redirect
        if ($this->_response->isRedirect()) {
            $headers = $this->_response->getHeaders();
            $redirect = '';
            foreach ($headers AS $header) {
                if ("Location" == $header["name"]) {
                    $redirect = $header["value"];
                    break;
                }
            }
            if ($redirect) {
                $this->setRedirect($redirect);
            }
        }

        $this->_response->clearHeaders();
        $this->_response->setHeader('Content-Type', 'application/json');
        $this->_response->clearBody();
        $this->_response->setBody($this->toJson());
        $this->_response->sendResponse();
        exit;
    }

    public function loadContent($actionContent, $customContent)
    {
        if ($actionContent) {
            $layout = $this->_loadControllerLayouts();
            $actionContentData = array();
            foreach ($actionContent as $_content) {
                $_block = $layout->getBlock($_content);
                if ($_block) {
                    $actionContentData[$_content] = $_block->toHtml();
                }
            }
            if ($actionContentData) {
                $this->setActionContentData($actionContentData);
            }
        }

        if ($customContent) {
            $layout = $this->_loadCustomLayouts();
            $customContentData = array();
            foreach ($customContent as $_content) {
                $_block = $layout->getBlock($_content);
                if ($_block) {
                    $customContentData[$_content] = $_block->toHtml();
                }
            }
            if ($customContentData) {
                $this->setCustomContentData($customContentData);
            }
        }
    }

    /**
     * Load layouts for current controller
     *
     * @return Mage_Core_Model_Layout
     */
    protected function _loadControllerLayouts()
    {
        $layout = Mage::app()->getLayout();
        $update = $layout->getUpdate();
        // load default handle
        $update->addHandle('default');
        // load store handle
        $update->addHandle('STORE_'.Mage::app()->getStore()->getCode());
        // load theme handle
        $package = Mage::getSingleton('core/design_package');
        $update->addHandle(
            'THEME_'.$package->getArea().'_'.$package->getPackageName().'_'.$package->getTheme('layout')
        );
        // load action handle
        $fullActionName = Mage::app()->getRequest()->getRequestedRouteName() . '_' .
            Mage::app()->getRequest()->getRequestedControllerName() . '_' .
            Mage::app()->getRequest()->getRequestedActionName();
        $update->addHandle(strtolower($fullActionName));

        //load updates
        $update->load();
        //generate xml
        $layout->generateXml();
        //generate layout blocks
        $layout->generateBlocks();

        return $layout;
    }

    /**
     * Load custom layout
     *
     * @return Mage_Core_Model_Layout
     */
    protected function _loadCustomLayouts()
    {
        $layout = Mage::app()->getLayout();
        $update = $layout->getUpdate();
        // load default custom handle
        $update->addHandle('easy_ajax_default');
        // load action handle
        $fullActionName = Mage::app()->getRequest()->getRequestedRouteName() . '_' .
            Mage::app()->getRequest()->getRequestedControllerName() . '_' .
            Mage::app()->getRequest()->getRequestedActionName();
        $update->addHandle('easy_ajax_' . strtolower($fullActionName));

        if (Mage::app()->useCache('layout')){
            $cacheId = $update->getCacheId().'_easy_ajax';
            $update->setCacheId($cacheId);

            if (!Mage::app()->loadCache($cacheId)) {
                foreach ($update->getHandles() as $handle) {
                    $update->merge($handle);
                }

                $update->saveCache();
            } else {
                //load updates from cache
                $update->load();
            }
        } else {
            //load updates
            $update->load();
        }

        //generate xml
        $layout->generateXml();
        //generate layout blocks
        $layout->generateBlocks();

        return $layout;
    }
}
