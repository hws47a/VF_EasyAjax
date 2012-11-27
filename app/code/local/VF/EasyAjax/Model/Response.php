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
class VF_EasyAjax_Model_Response extends Mage_Core_Model_Abstract
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
        $this->_response->clearHeaders();
        $this->_response->setHeader('Content-Type', 'application/json');
        $this->_response->clearBody();
        $this->_response->setBody($this->toJson());
        $this->_response->sendResponse();
        exit;
    }
}
