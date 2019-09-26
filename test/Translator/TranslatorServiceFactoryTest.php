<?php
/**
 * @see       https://github.com/zendframework/zend-i18n for the canonical source repository
 * @copyright Copyright (c) 2005-2019 Zend Technologies USA Inc. (https://www.zend.com)
 * @license   https://github.com/zendframework/zend-i18n/blob/master/LICENSE.md New BSD License
 */

namespace ZendTest\I18n\Translator;

use Interop\Container\ContainerInterface;
use PHPUnit\Framework\TestCase;
use Zend\I18n\Translator\LoaderPluginManager;
use Zend\I18n\Translator\TranslatorServiceFactory;
use Zend\I18n\Translator\Translator;

class TranslatorServiceFactoryTest extends TestCase
{
    public function testCreateServiceWithNoTranslatorKeyDefined()
    {
        $pluginManagerMock = $this->createMock(LoaderPluginManager::class);
        $slContents        = [
            ['config', []],
            ['TranslatorPluginManager', $pluginManagerMock]
        ];

        $serviceLocator = $this->createMock(ContainerInterface::class);
        $serviceLocator
            ->expects($this->exactly(1))
            ->method('has')
            ->with($this->equalTo('TranslatorPluginManager'))
            ->will($this->returnValue(true));
        $serviceLocator
            ->expects($this->exactly(2))
            ->method('get')
            ->will($this->returnValueMap($slContents));

        $factory = new TranslatorServiceFactory();
        $translator = $factory($serviceLocator, Translator::class);
        $this->assertInstanceOf(Translator::class, $translator);
        $this->assertSame($pluginManagerMock, $translator->getPluginManager());
    }

    public function testCreateServiceWithNoTranslatorPluginManagerDefined()
    {
        $serviceLocator = $this->createMock(ContainerInterface::class);
        $serviceLocator
            ->expects($this->exactly(1))
            ->method('get')
            ->with($this->equalTo('config'))
            ->will($this->returnValue([]));

        $factory = new TranslatorServiceFactory();
        $translator = $factory($serviceLocator, Translator::class);
        $this->assertInstanceOf(Translator::class, $translator);
    }
}
