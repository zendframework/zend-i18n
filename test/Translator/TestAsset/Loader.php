<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ZendTest\I18n\Translator\TestAsset;

use Zend\I18n\Translator\Loader\FileLoaderInterface;

/**
 * Test loader.
 */
class Loader implements FileLoaderInterface
{
    public $textDomain;

    /**
     * load(): defined by LoaderInterface.
     *
     * @see    LoaderInterface::load()
     * @param  string $filename
     * @param  string $locale
     * @return TextDomain|null
     */
    public function load($filename, $locale)
    {
        return $this->textDomain;
    }
}
