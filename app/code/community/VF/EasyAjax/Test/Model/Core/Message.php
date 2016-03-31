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
 * Core message model test case
 *
 * @category   VF
 * @package    VF_EasyAjax
 * @subpackage Test
 * @author     Vladimir Fishchenko <vladimir@fishchenko.com>
 */
class VF_EasyAjax_Test_Model_Core_Message
    extends EcomDev_PHPUnit_Test_Case
{
    /**
     * Save all messages to storage if it's an easy ajax request
     *
     * @singleton easyAjax/core
     * @singleton easyAjax/message_storage
     */
    public function testStorageAddMessage()
    {
        $this->enableEasyAjax(true);
        $this->mockModel('easyAjax/message_storage', array('addMessage'))
            ->replaceByMock('singleton')
            ->expects($this->exactly(2))
            ->method('addMessage')
            ->withConsecutive(
                array('Success message', 'success'),
                array('Error message', 'error')
            );

        $message = Mage::getModel('core/message');
        $message->success('Success message');
        $message->error('Error message');
    }

    /**
     * Don't save messages to storage
     * when it isn't easy ajax request
     *
     * @singleton easyAjax/core
     * @singleton easyAjax/message_storage
     */
    public function testStorageNotAddMessage()
    {
        $this->enableEasyAjax(false);
        $this->mockModel('easyAjax/message_storage', array('addMessage'))
            ->replaceByMock('singleton')
            ->expects($this->never())
            ->method('addMessage');

        $message = Mage::getModel('core/message');
        $message->success('Success message');
        $message->error('Error message');
    }

    /**
     * Don't save messages to storage
     * when module is disabled and there is no exception
     *
     * @singleton easyAjax/core
     * @singleton easyAjax/message_storage
     */
    public function testStorageModuleDisabled()
    {
        $this->mockHelper('core', array('isModuleEnabled'))
            ->replaceByMock('helper')
            ->expects($this->any())
            ->method('isModuleEnabled')
            ->with($this->equalTo('VF_EasyAjax'))
            ->willReturn(false);

        //trying to emulate incorrect singleton exception when module is disabled
        $this->mockModel('easyAjax/core', array('isEasyAjax'))
            ->replaceByMock('singleton')
            ->expects($this->any())
            ->method('isEasyAjax')
            ->willThrowException(new Exception('Method doesn\'t exist!'));

        $this->mockModel('easyAjax/message_storage', array('addMessage'))
            ->replaceByMock('singleton')
            ->expects($this->never())
            ->method('addMessage');

        $message = Mage::getModel('core/message');
        $message->success('Success message');
        $message->error('Error message');
    }

    /**
     * Enabled or disabled easy ajax
     *
     * @param bool $value
     */
    protected function enableEasyAjax($value)
    {
        $this->mockModel('easyAjax/core', array('isEasyAjax'))
            ->replaceByMock('singleton')
            ->expects($this->any())
            ->method('isEasyAjax')
            ->willReturn((bool)$value);
    }
}