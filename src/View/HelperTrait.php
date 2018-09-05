<?php
/**
 * @see       https://github.com/zendframework/zend-i18n for the canonical source repository
 * @copyright Copyright (c) 2005-2018 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   https://github.com/zendframework/zend-i18n/blob/master/LICENSE.md New BSD License
 */

namespace Zend\I18n\View;

use IntlDateFormatter;

// @codingStandardsIgnoreStart

/**
 * Trait HelperTrait
 *
 * The trait provides convenience methods for view helpers,
 * defined by the zend-i18n component. It is designed to be used
 * for type-hinting $this variable inside zend-view templates via doc blocks.
 *
 * The base class is PhpRenderer, followed by the helper trait from
 * the zend-i18n component. However, multiple helper traits from different
 * Zend Framework components can be chained afterwards.
 *
 * @example @var \Zend\View\Renderer\PhpRenderer|\Zend\I18n\View\HelperTrait $this
 *
 * @method string currencyFormat($number, $currencyCode = null, $showDecimals = null, $locale = null, $pattern = null)
 * @method string dateFormat($date, $dateType = IntlDateFormatter::NONE, $timeType = IntlDateFormatter::NONE, $locale = null, $pattern = null)
 * @method string numberFormat($number, $formatStyle = null, $formatType = null, $locale = null, $decimals = null, array $textAttributes = null)
 * @method string plural($strings, $number)
 * @method string translate($message, $textDomain = null, $locale = null)
 * @method string translatePlural($singular, $plural, $number, $textDomain = null, $locale = null)
 */
trait HelperTrait
{
}
// @codingStandardsIgnoreEnd
