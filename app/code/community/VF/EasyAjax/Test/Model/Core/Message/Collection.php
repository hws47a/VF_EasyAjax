<?php
/**
 * Vladimir Fishchenko extension for Magento
 * NOTICE OF LICENSE
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
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
 * Message collection model test case
 *
 * @category   VF
 * @package    VF_EasyAjax
 * @subpackage Test
 * @author     Vladimir Fishchenko <vladimir@fishchenko.com>
 */
class VF_EasyAjax_Test_Model_Core_Message_Collection
    extends EcomDev_PHPUnit_Test_Case
{
    /**
     * Test that messages are not added to collection
     * when it's easy ajax request
     *
     * @singleton easyAjax/core
     */
    public function testSkipAddMessage()
    {
        $this->enableEasyAjax(true);
        $model = Mage::getModel('core/message_collection');

        $countBefore = count($model->getItems());
        $message = Mage::getModel('core/message_success');
        $message->setCode('Some message');
        $model->add($message);
        $this->assertEquals($countBefore, count($model->getItems()));
    }

    /**
     * Test that messages are added to collection
     * when it isn't easy ajax request
     *
     * @singleton easyAjax/core
     */
    public function testAddMessage()
    {
        $this->enableEasyAjax(false);
        $model = Mage::getModel('core/message_collection');

        $countBefore = count($model->getItems());
        $message = Mage::getModel('core/message_success');
        $message->setCode('Some message');
        $model->add($message);
        $this->assertEquals($countBefore + 1, count($model->getItems()));
    }

    /**
     * Test that messages are added to collection
     * when module is disabled and there is no exception
     *
     * @singleton easyAjax/core
     */
    public function testModuleDisabled()
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

        $model = Mage::getModel('core/message_collection');

        $countBefore = count($model->getItems());
        $message = Mage::getModel('core/message_success');
        $message->setCode('Some message');
        $model->add($message);
        $this->assertEquals($countBefore + 1, count($model->getItems()));
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