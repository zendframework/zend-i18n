<?php
/**
 * @link      http://github.com/zendframework/zend-i18n for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ZendTest\I18n\Translator;

use Interop\Container\ContainerInterface;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\I18n\Translator\LoaderPluginManager;
use Zend\I18n\Translator\LoaderPluginManagerFactory;
use Zend\ServiceManager\ServiceLocatorInterface;

class LoaderPluginManagerFactoryTest extends TestCase
{
    public function testFactoryReturnsUnconfiguredPluginManagerWhenNoOptionsPresent()
    {
        $container = $this->prophesize(ContainerInterface::class)->reveal();

        $factory = new LoaderPluginManagerFactory();
        $loaders = $factory($container, 'TranslatorPluginManager');
        $this->assertInstanceOf(LoaderPluginManager::class, $loaders);
        $this->assertFalse($loaders->has('test'));
    }

    public function testCreateServiceReturnsUnconfiguredPluginManagerWhenNoOptionsPresent()
    {
        $container = $this->prophesize(ServiceLocatorInterface::class);
        $container->willImplement(ContainerInterface::class);

        $factory = new LoaderPluginManagerFactory();
        $loaders = $factory->createService($container->reveal());
        $this->assertInstanceOf(LoaderPluginManager::class, $loaders);
        $this->assertFalse($loaders->has('test'));
    }

    public function provideLoader()
    {
        return [
            ['gettext'],
            ['getText'],
            ['GetText'],
            ['phparray'],
            ['phpArray'],
            ['PhpArray'],
        ];
    }

    /**
     * @dataProvider provideLoader
     */
    public function testFactoryCanConfigurePluginManagerViaOptions($loader)
    {
        $container = $this->prophesize(ContainerInterface::class)->reveal();

        $factory = new LoaderPluginManagerFactory();
        $loaders = $factory($container, 'TranslatorPluginManager', ['aliases' => [
            'test' => $loader,
        ]]);
        $this->assertInstanceOf(LoaderPluginManager::class, $loaders);
        $this->assertTrue($loaders->has('test'));
    }

    /**
     * @dataProvider provideLoader
     */
    public function testCreateServiceCanConfigurePluginManagerViaOptions($loader)
    {
        $container = $this->prophesize(ServiceLocatorInterface::class);
        $container->willImplement(ContainerInterface::class);

        $factory = new LoaderPluginManagerFactory();
        $factory->setCreationOptions(['aliases' => [
            'test' => $loader,
        ]]);
        $loaders = $factory->createService($container->reveal());
        $this->assertInstanceOf(LoaderPluginManager::class, $loaders);
        $this->assertTrue($loaders->has('test'));
    }
}
