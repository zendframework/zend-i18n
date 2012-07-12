<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   Zend_I18n
 */

namespace ZendTest\I18n\Translator\Loader;

use PHPUnit_Framework_TestCase as TestCase;
use Locale;
use Zend\I18n\Translator\Translator;
use Zend\I18n\Translator\Loader\PhpArray as PhpArrayLoader;

class PhpArrayTest extends TestCase
{
    protected $testFilesDir;
    protected $originalLocale;

    public function setUp()
    {
        $this->originalLocale = Locale::getDefault();
        Locale::setDefault('en_EN');

        $this->testFilesDir = realpath(__DIR__ . '/../_files');
    }

    public function tearDown()
    {
        Locale::setDefault($this->originalLocale);
    }

    public function testLoaderFailsToLoadMissingFile()
    {
        $loader = new PhpArrayLoader();
        $this->setExpectedException('Zend\I18n\Exception\InvalidArgumentException', 'Could not open file');
        $loader->load('missing', 'en_EN');
    }

    public function testLoaderFailsToLoadNonArray()
    {
        $loader = new PhpArrayLoader();
        $this->setExpectedException('Zend\I18n\Exception\InvalidArgumentException',
                                    'Expected an array, but received');
        $loader->load($this->testFilesDir . '/failed.php', 'en_EN');
    }

    public function testLoaderLoadsEmptyArray()
    {
        $loader = new PhpArrayLoader();
        $textDomain = $loader->load($this->testFilesDir . '/translation_empty.php', 'en_EN');
        $this->assertInstanceOf('Zend\I18n\Translator\TextDomain', $textDomain);
    }

    public function testTranslatorAddsFile()
    {
        $translator = new Translator();
        $translator->addTranslationFile('phparray', $this->testFilesDir . '/translation_en.php');

        $this->assertEquals('Message 1 (en)', $translator->translate('Message 1'));
        $this->assertEquals('Message 6', $translator->translate('Message 6'));
    }

    public function testTranslatorAddsFileToTextDomain()
    {
        $translator = new Translator();
        $translator->addTranslationFile('phparray', $this->testFilesDir . '/translation_en.php', 'user');

        $this->assertEquals('Message 2 (en)', $translator->translate('Message 2', 'user'));
    }

    public function testTranslatorAddsPattern()
    {
        $translator = new Translator();
        $translator->addTranslationPattern(
            'phparray',
            $this->testFilesDir . '/testarray',
            'translation-%s.php'
        );

        $this->assertEquals('Message 1 (en)', $translator->translate('Message 1', 'default', 'en_US'));
        $this->assertEquals('Nachricht 1', $translator->translate('Message 1', 'default', 'de_DE'));
    }

    public function testLoaderLoadsPluralRules()
    {
        $loader = new PhpArrayLoader();
        $domain = $loader->load($this->testFilesDir . '/translation_en.php', 'en_EN');

        $this->assertEquals(2, $domain->getPluralRule()->evaluate(0));
        $this->assertEquals(0, $domain->getPluralRule()->evaluate(1));
        $this->assertEquals(1, $domain->getPluralRule()->evaluate(2));
        $this->assertEquals(2, $domain->getPluralRule()->evaluate(10));
    }

    public function testTranslatorTranslatesPlurals()
    {
        $translator = new Translator();
        $translator->setLocale('en_EN');
        $translator->addTranslationFile(
            'phparray',
            $this->testFilesDir . '/translation_en.php',
            'default',
            'en_EN'
        );

        $pl0 = $translator->translatePlural('Message 5', 'Message 5 Plural', 1);
        $pl1 = $translator->translatePlural('Message 5', 'Message 5 Plural', 2);
        $pl2 = $translator->translatePlural('Message 5', 'Message 5 Plural', 10);

        $this->assertEquals('Message 5 (en) Plural 0', $pl0);
        $this->assertEquals('Message 5 (en) Plural 1', $pl1);
        $this->assertEquals('Message 5 (en) Plural 2', $pl2);
    }
}
