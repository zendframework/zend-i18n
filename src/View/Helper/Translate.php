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
use Zend\I18n\Translator\Translator;
use Zend\View\Helper\AbstractHelper;

/**
 * View helper for translating messages.
 *
 * @category   Zend
 * @package    Zend_I18n
 * @subpackage View
 */
class Translate extends AbstractHelper
{
    /**
     * Translate a message.
     *
     * @param  string $message
     * @param  string $textDomain
     * @param  string $locale
     * @return string
     * @throws Exception\RuntimeException
     */
    public function __invoke($message, $textDomain = 'default', $locale = null)
    {
        $translator = $this->getTranslator();
        if (null === $translator) {
            throw new Exception\RuntimeException('Translator has not been set');
        }
        return $translator->translate($message, $textDomain, $locale);
    }
}
