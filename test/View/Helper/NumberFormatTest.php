<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ZendTest\I18n\View\Helper;

use Locale;
use NumberFormatter;
use Zend\I18n\View\Helper\NumberFormat as NumberFormatHelper;

/**
 * Test class for Zend\View\Helper\Currency
 *
 * @group      Zend_View
 * @group      Zend_View_Helper
 */
class NumberFormatTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var NumberFormatHelper
     */
    public $helper;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     */
    public function setUp()
    {
        if (!extension_loaded('intl')) {
            $this->markTestSkipped('ext/intl not enabled');
        }

        $this->helper = new NumberFormatHelper();
    }

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->helper);
    }

    public function currencyTestsDataProvider()
    {
        if (!extension_loaded('intl')) {
            if (version_compare(\PHPUnit_Runner_Version::id(), '3.8.0-dev') === 1) {
                $this->markTestSkipped('ext/intl not enabled');
            } else {
                return [[]];
            }
        }

        return [
            [
                'de_DE',
                NumberFormatter::DECIMAL,
                NumberFormatter::TYPE_DOUBLE,
                null,
                [],
                1234567.891234567890000,
                '1.234.567,891'
            ],
            [
                'de_DE',
                NumberFormatter::DECIMAL,
                NumberFormatter::TYPE_DOUBLE,
                6,
                [],
                1234567.891234567890000,
                '1.234.567,891235',
            ],
            [
                'de_DE',
                NumberFormatter::PERCENT,
                NumberFormatter::TYPE_DOUBLE,
                null,
                [],
                1234567.891234567890000,
                '123.456.789 %'
            ],
            [
                'de_DE',
                NumberFormatter::PERCENT,
                NumberFormatter::TYPE_DOUBLE,
                1,
                [],
                1234567.891234567890000,
                '123.456.789,1 %'
            ],
            [
                'de_DE',
                NumberFormatter::SCIENTIFIC,
                NumberFormatter::TYPE_DOUBLE,
                null,
                [],
                1234567.891234567890000,
                '1,23456789123457E6'
            ],
            [
                'ru_RU',
                NumberFormatter::DECIMAL,
                NumberFormatter::TYPE_DOUBLE,
                null,
                [],
                1234567.891234567890000,
                '1 234 567,891'
            ],
            [
                'ru_RU',
                NumberFormatter::PERCENT,
                NumberFormatter::TYPE_DOUBLE,
                null,
                [],
                1234567.891234567890000,
                '123 456 789 %'
            ],
            [
                'ru_RU',
                NumberFormatter::SCIENTIFIC,
                NumberFormatter::TYPE_DOUBLE,
                null,
                [],
                1234567.891234567890000,
                '1,23456789123457E6'
            ],
            [
                'en_US',
                NumberFormatter::DECIMAL,
                NumberFormatter::TYPE_DOUBLE,
                null,
                [],
                1234567.891234567890000,
                '1,234,567.891'
            ],
            [
                'en_US',
                NumberFormatter::PERCENT,
                NumberFormatter::TYPE_DOUBLE,
                null,
                [],
                1234567.891234567890000,
                '123,456,789%'
            ],
            [
                'en_US',
                NumberFormatter::SCIENTIFIC,
                NumberFormatter::TYPE_DOUBLE,
                null,
                [],
                1234567.891234567890000,
                '1.23456789123457E6'
            ],
            [
                'en_US',
                NumberFormatter::PERCENT,
                NumberFormatter::TYPE_DOUBLE,
                null,
                [
                    NumberFormatter::NEGATIVE_PREFIX => 'MINUS'
                ],
                -1234567.891234567890000,
                'MINUS123,456,789%'
            ],
        ];
    }

    /**
     * @dataProvider currencyTestsDataProvider
     */
    public function testBasic($locale, $formatStyle, $formatType, $decimals, $textAttributes, $number, $expected)
    {
        $this->assertMbStringEquals($expected, $this->helper->__invoke(
            $number,
            $formatStyle,
            $formatType,
            $locale,
            $decimals,
            $textAttributes
        ));
    }

    /**
     * @dataProvider currencyTestsDataProvider
     */
    public function testSettersProvideDefaults(
        $locale,
        $formatStyle,
        $formatType,
        $decimals,
        $textAttributes,
        $number,
        $expected
    ) {
        $this->helper
             ->setLocale($locale)
             ->setFormatStyle($formatStyle)
             ->setDecimals($decimals)
             ->setFormatType($formatType)
             ->setTextAttributes($textAttributes);

        $this->assertMbStringEquals($expected, $this->helper->__invoke($number));
    }

    public function testDefaultLocale()
    {
        $this->assertEquals(Locale::getDefault(), $this->helper->getLocale());
    }

    public function assertMbStringEquals($expected, $test, $message = '')
    {
        $expected = str_replace(["\xC2\xA0", ' '], '', $expected);
        $test     = str_replace(["\xC2\xA0", ' '], '', $test);
        $this->assertEquals($expected, $test, $message);
    }
}
