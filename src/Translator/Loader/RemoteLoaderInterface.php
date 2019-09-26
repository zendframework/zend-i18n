<?php
/**
 * @see       https://github.com/zendframework/zend-i18n for the canonical source repository
 * @copyright Copyright (c) 2005-2019 Zend Technologies USA Inc. (https://www.zend.com)
 * @license   https://github.com/zendframework/zend-i18n/blob/master/LICENSE.md New BSD License
 */

namespace Zend\I18n\Translator\Loader;

/**
 * Remote loader interface.
 */
interface RemoteLoaderInterface
{
    /**
     * Load translations from a remote source.
     *
     * @param  string $locale
     * @param  string $textDomain
     * @return \Zend\I18n\Translator\TextDomain|null
     */
    public function load($locale, $textDomain);
}
