<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zend-i18n for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ZendTest\I18n\Translator;

use PHPUnit_Framework_TestCase as TestCase;
use Zend\I18n\Exception\RuntimeException;
use Zend\I18n\Translator\LoaderPluginManager;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\Test\CommonPluginManagerTrait;

class LoaderPluginManagerCompatibilityTest extends TestCase
{
    use CommonPluginManagerTrait;

    protected function getPluginManager()
    {
        return new LoaderPluginManager(new ServiceManager());
    }

    protected function getV2InvalidPluginException()
    {
        return RuntimeException::class;
    }

    protected function getInstanceOf()
    {
        return Filter\FilterInterface::class;
    }

    public function testInstanceOfMatches()
    {
        $this->markTestSkipped('Test skipped as LoaderPluginManager allows multiple instance types');
    }
}
