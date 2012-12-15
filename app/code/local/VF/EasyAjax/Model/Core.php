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
 * @copyright  Copyright (C) 2012 
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Easy ajax core model
 *
 * @category   VF
 * @package    VF_EasyAjax
 * @subpackage Model
 * @author     
 */
class VF_EasyAjax_Model_Core
{
    public function isEasyAjax()
    {
        return Mage::app()->getRequest()->isXmlHttpRequest() && Mage::app()->getRequest()->getParam('easy_ajax', false);
    }
}
