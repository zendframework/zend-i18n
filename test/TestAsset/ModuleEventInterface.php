<?php
/**
 * @link      http://github.com/zendframework/zend-i18n for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ZendTest\I18n\TestAsset;

/**
 * Mock interface to use when testing Module::init
 *
 * Mimics Zend\ModuleManager\ModuleEvent methods called.
 */
interface ModuleEventInterface
{
    public function getParam($name, $default = null);
}
