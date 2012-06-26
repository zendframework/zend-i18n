<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_I18n
 * @subpackage Translator
 * @copyright  Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */

namespace Zend\I18n\Translator;

use ArrayObject;
use Zend\I18n\Translator\Plural\Rule as PluralRule;

/**
 * Text domain.
 *
 * @category   Zend
 * @package    Zend_I18n
 * @subpackage Translator
 * @copyright  Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class TextDomain extends ArrayObject
{
    /**
     * Plural rule.
     *
     * @var PluralRule
     */
    protected $pluralRule;

    /**
     * Get or set the plural rule.
     *
     * @param  PluralRule $rule
     * @return PluralRule
     */
    public function pluralRule(PluralRule $rule = null)
    {
        if ($rule !== null) {
            $this->pluralRule = $rule;
        } elseif ($this->pluralRule === null) {
            $this->pluralRule = PluralRule::fromString('nplurals=2; plural=n==1');
        }

        return $this->pluralRule;
    }
}
