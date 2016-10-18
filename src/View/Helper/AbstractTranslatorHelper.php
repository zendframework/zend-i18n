<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\I18n\View\Helper;

use Zend\I18n\Translator\TranslatorInterface as Translator;
use Zend\I18n\Translator\TranslatorAwareInterface;
use Zend\View\Helper\AbstractHelper;

abstract class AbstractTranslatorHelper extends AbstractHelper implements
    TranslatorAwareInterface
{
    /**
     * Translator (optional)
     *
     * @var Translator
     */
    protected $translator;

    /**
     * Translator text domain (optional)
     *
     * @var string
     */
    protected $translatorTextDomain = null;

    /**
     * Whether translator should be used
     *
     * @var bool
     */
    protected $translatorEnabled = true;

    /**
     * Default translation object for all view helpers
     * @var Translator
     */
    protected static $defaultTranslator;

    /**
     * Default text domain to be used with translator
     * @var string
     */
    protected static $defaultTranslatorTextDomain = 'default';

    /**
     * Sets translator to use in helper
     *
     * @param  Translator $translator  [optional] translator.
     *                                 Default is null, which sets no translator.
     * @param  string     $textDomain  [optional] text domain
     *                                 Default is null, which skips setTranslatorTextDomain
     * @return AbstractTranslatorHelper
     */
    public function setTranslator(Translator $translator = null, $textDomain = null)
    {
        $this->translator = $translator;
        if (null !== $textDomain) {
            $this->setTranslatorTextDomain($textDomain);
        }

        return $this;
    }

    /**
     * Returns translator used in helper
     *
     * @return Translator|null
     */
    public function getTranslator()
    {
        if (! $this->isTranslatorEnabled()) {
            return;
        }

        if (self::hasDefaultTranslator()) {
            $this->translator = self::getDefaultTranslator();
        }

        return $this->translator;
    }

    /**
     * Checks if the helper has a translator
     *
     * @return bool
     */
    public function hasTranslator()
    {
        return (bool) $this->getTranslator();
    }

    /**
     * Sets whether translator is enabled and should be used
     *
     * @param  bool $enabled
     * @return AbstractTranslatorHelper
     */
    public function setTranslatorEnabled($enabled = true)
    {
        $this->translatorEnabled = (bool) $enabled;
        return $this;
    }

    /**
     * Returns whether translator is enabled and should be used
     *
     * @return bool
     */
    public function isTranslatorEnabled()
    {
        return $this->translatorEnabled;
    }

    /**
     * Set translation text domain
     *
     * @param  string $textDomain
     * @return AbstractTranslatorHelper
     */
    public function setTranslatorTextDomain($textDomain = 'default')
    {
        $this->translatorTextDomain = $textDomain;
        return $this;
    }

    /**
     * Return the translation text domain
     *
     * @return string
     */
    public function getTranslatorTextDomain()
    {
        if ($this->translatorTextDomain === null) {
            $this->translatorTextDomain = self::getDefaultTranslatorTextDomain();
        }
        return $this->translatorTextDomain;
    }

    /**
     * Set default translation object for all view helpers
     *
     * @param  Translator|null $translator
     * @param  string          $textDomain (optional)
     * @return void
     */
    public static function setDefaultTranslator(Translator $translator = null, $textDomain = null)
    {
        static::$defaultTranslator = $translator;
        if (null !== $textDomain) {
            self::setDefaultTranslatorTextDomain($textDomain);
        }
    }

    /**
     * Get default translation object for all view helpers
     *
     * @return Translator|null
     */
    public static function getDefaultTranslator()
    {
        return static::$defaultTranslator;
    }

    /**
     * Is there a default translation object set?
     *
     * @return bool
     */
    public static function hasDefaultTranslator()
    {
        return (bool) static::$defaultTranslator;
    }

    /**
     * Set default translation text domain for all view helpers
     *
     * @param  string $textDomain
     * @return void
     */
    public static function setDefaultTranslatorTextDomain($textDomain = 'default')
    {
        static::$defaultTranslatorTextDomain = $textDomain;
    }

    /**
     * Get default translation text domain for all view helpers
     *
     * @return string
     */
    public static function getDefaultTranslatorTextDomain()
    {
        return static::$defaultTranslatorTextDomain;
    }
}
