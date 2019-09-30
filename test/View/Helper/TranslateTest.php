<?php
/**
 * @see       https://github.com/zendframework/zend-i18n for the canonical source repository
 * @copyright Copyright (c) 2005-2019 Zend Technologies USA Inc. (https://www.zend.com)
 * @license   https://github.com/zendframework/zend-i18n/blob/master/LICENSE.md New BSD License
 */

namespace ZendTest\I18n\View\Helper;

use PHPUnit\Framework\TestCase;
use Zend\I18n\View\Helper\Translate as TranslateHelper;

/**
 * @group      Zend_View
 * @group      Zend_View_Helper
 */
class TranslateTest extends TestCase
{
    /**
     * @var TranslateHelper
     */
    public $helper;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     */
    protected function setUp()
    {
        $this->helper = new TranslateHelper();
    }

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     *
     * @return void
     */
    protected function tearDown()
    {
        unset($this->helper);
    }

    public function testInvokingWithoutTranslatorWillRaiseException()
    {
        $this->expectException('Zend\I18n\Exception\RuntimeException');
        $this->helper->__invoke('message');
    }

    public function testDefaultInvokeArguments()
    {
        $input    = 'input';
        $expected = 'translated';

        $translatorMock = $this->createMock('Zend\I18n\Translator\Translator');
        $translatorMock->expects($this->once())
                       ->method('translate')
                       ->with($this->equalTo($input), $this->equalTo('default'), $this->equalTo(null))
                       ->willReturn($expected);

        $this->helper->setTranslator($translatorMock);

        $this->assertEquals($expected, $this->helper->__invoke($input));
    }

    public function testCustomInvokeArguments()
    {
        $input      = 'input';
        $expected   = 'translated';
        $textDomain = 'textDomain';
        $locale     = 'en_US';

        $translatorMock = $this->createMock('Zend\I18n\Translator\Translator');
        $translatorMock->expects($this->once())
                       ->method('translate')
                       ->with($this->equalTo($input), $this->equalTo($textDomain), $this->equalTo($locale))
                       ->willReturn($expected);

        $this->helper->setTranslator($translatorMock);

        $this->assertEquals($expected, $this->helper->__invoke($input, $textDomain, $locale));
    }
}
