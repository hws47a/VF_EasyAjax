<?php
/**
 * Vladimir Fishchenko extension for Magento
 *
 * NOTICE OF LICENSE
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * DISCLAIMER
 * Do not edit or add to this file if you wish to upgrade
 * the VF EasyAjax module to newer versions in the future.
 * If you wish to customize the VF EasyAjax module for your needs
 * please refer to https://github.com/hws47a/VF_EasyAjax for more information.
 *
 * @category   VF
 * @package    VF_EasyAjax
 * @copyright  Copyright (C) 2016 Vladimir Fishchenko (https://fishchenko.com/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Message storage test case
 *
 * @category   VF
 * @package    VF_EasyAjax
 * @subpackage Test
 * @author     Vladimir Fishchenko <vladimir@fishchenko.com>
 */
class VF_EasyAjax_Test_Model_Message_Storage
    extends EcomDev_PHPUnit_Test_Case
{
    /**
     * Test Message Storage Functionality
     */
    public function testStorage()
    {
        $storage = Mage::getModel('easyAjax/message_storage');
        $this->assertEmpty($storage->getMessages());
        $messages = array(
            array('code' => 'First Message', 'type' => 'success'),
            array('code' => 'Second Message', 'type' => 'error'),
        );

        foreach ($messages as $item) {
            $storage->addMessage($item['code'], $item['type']);
        }

        $this->assertEquals($messages, $storage->getMessages());
    }
}