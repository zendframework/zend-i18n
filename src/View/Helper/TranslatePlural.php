<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   Zend_I18n
 */

namespace Zend\I18n\View\Helper;

use Zend\I18n\Exception;

/**
 * View helper for translating plural messages.
 *
 * @category   Zend
 * @package    Zend_I18n
 * @subpackage View
 */
class TranslatePlural extends AbstractTranslatorHelper
{
    /**
     * Translate a plural message.
     *
     * @param  string  $singular
     * @param  string  $plural
     * @param  integer $number
     * @param  string  $textDomain
     * @param  string  $locale
     * @return string
     * @throws Exception\RuntimeException
     */
    public function __invoke(
        $singular,
        $plural,
        $number,
        $textDomain = 'default',
        $locale = null
    )
    {
        $translator = $this->getTranslator();
        if (null === $translator) {
            throw new Exception\RuntimeException('Translator has not been set');
        }
        return $translator->translatePlural($singular, $plural, $number, $textDomain, $locale);
    }
}
