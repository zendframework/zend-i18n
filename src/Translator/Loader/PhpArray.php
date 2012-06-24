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
 * @package    Zend_I18n_Translator
 * @copyright  Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */

namespace Zend\I18n\Translator\Loader;

use Zend\I18n\Translator\Exception;

/**
 * PHP array loader.
 *
 * @package    Zend_I18n_Translator
 * @copyright  Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class PhpArray implements LoaderInterface
{
    /**
     * load(): defined by LoaderInterface.
     * 
     * @see    LoaderInterface::load()
     * @param  string $filename
     * @return array 
     */
    public function load($filename)
    {
        if (!is_file($filename) || !is_readable($filename)) {
            throw new Exception\InvalidArgumentException(
                sprintf('Could not open file %s for reading', $filename)
            );
        }
        
        $translations = include $filename;
        
        if (!is_array($translations)) {
            throw new Exception\InvalidArgumentException(
                sprintf('Expected an array, but received %s', gettype($translations))
            );            
        } 
        
        
        return $translations;
    }
}
