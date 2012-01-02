<?php
/**
 * Open Source Magento Extensions extension
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
 * the Osme EasyAjax module to newer versions in the future.
 * If you wish to customize the Osme EasyAjax module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Osme
 * @package    Osme_EasyAjax
 * @copyright  Copyright (C) 2012 Open Source Magento Extensions (http://github.com/osme)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * EasyAjax Event Observer
 *
 * @category   Osme
 * @package    Osme_EasyAjax
 * @subpackage Model
 * @author     Vladimir Fishchenko <hws47a@gmail.com>
 */
class Osme_EasyAjax_Model_Observer
{
    public function getJson() {
        if (Mage::app()->getRequest()->isAjax()) {
            /** @var $messages Osme_EasyAjax_Model_Message_Storage */
            $messages = Mage::getSingleton('easyAjax/message_storage');
            /** @var $response Osme_EasyAjax_Model_Response */
            $response = Mage::getModel('easyAjax/response');
            $response->setMessages($messages->getMessages());
            $response->sendResponse();
        }
    }
}
