# I18n View Helpers

## Introduction

Zend Framework comes with an initial set of helper classes related to Internationalization: e.g.,
formatting a date, formatting currency, or displaying translated content. You can use helper, or
plugin, classes to perform these behaviors for you.

See the section on \[view helpers\](zend.view.helpers) for more information.

## CurrencyFormat Helper

The `CurrencyFormat` view helper can be used to simplify rendering of localized currency values. It
acts as a wrapper for the `NumberFormatter` class within the Internationalization extension (Intl).

### Basic Usage

```php
// Within your view

echo $this->currencyFormat(1234.56, 'USD', null, 'en_US');
// This returns: "$1,234.56"

echo $this->currencyFormat(1234.56, 'EUR', null, 'de_DE');
// This returns: "1.234,56 €"

echo $this->currencyFormat(1234.56, 'USD', true, 'en_US');
// This returns: "$1,234.56"

echo $this->currencyFormat(1234.56, 'USD', false, 'en_US');
// This returns: "$1,235"

echo $this->currencyFormat(12345678.90, 'EUR', true, 'de_DE', '#0.# kg');
// This returns: "12345678,90 kg"

echo $this->currencyFormat(12345678.90, 'EUR', false, 'de_DE', '#0.# kg');
// This returns: "12345679 kg"
```

### Available Methods

**Set the currency code and the locale**

The `$currencyCode` and `$locale` options can be set prior to formatting and will be applied each
time the helper is used:

```php
// Within your view

$this->plugin('currencyformat')->setCurrencyCode('USD')->setLocale('en_US');

echo $this->currencyFormat(1234.56);
// This returns: "$1,234.56"

echo $this->currencyFormat(5678.90);
// This returns: "$5,678.90"
```

**Show decimals**

```php
// Within your view

$this->plugin('currencyformat')->setShouldShowDecimals(false);

echo $this->currencyFormat(1234.56, 'USD', null, 'en_US');
// This returns: "$1,235"
```

**Set currency pattern**

```php
// Within your view

$this->plugin('currencyformat')->setCurrencyPattern('#0.# kg');

echo $this->currencyFormat(12345678.90, 'EUR', null, 'de_DE');
// This returns: "12345678,90 kg"
```

## DateFormat Helper

The `DateFormat` view helper can be used to simplify rendering of localized date/time values. It
acts as a wrapper for the `IntlDateFormatter` class within the Internationalization extension
(Intl).

### Basic Usage

```php
// Within your view

// Date and Time
echo $this->dateFormat(
    new DateTime(),
    IntlDateFormatter::MEDIUM, // date
    IntlDateFormatter::MEDIUM, // time
    "en_US"
);
// This returns: "Jul 2, 2012 6:44:03 PM"

// Date Only
echo $this->dateFormat(
    new DateTime(),
    IntlDateFormatter::LONG, // date
    IntlDateFormatter::NONE, // time
    "en_US"
);
// This returns: "July 2, 2012"

// Time Only
echo $this->dateFormat(
    new DateTime(),
    IntlDateFormatter::NONE,  // date
    IntlDateFormatter::SHORT, // time
    "en_US"
);
// This returns: "6:44 PM"
```

### Public Methods

The `$locale` option can be set prior to formatting with the `setLocale()` method and will be
applied each time the helper is used.

By default, the system's default timezone will be used when formatting. This overrides any timezone
that may be set inside a DateTime object. To change the timezone when formatting, use the
`setTimezone` method.

```php
// Within your view
$this->plugin("dateFormat")->setTimezone("America/New_York")->setLocale("en_US");

echo $this->dateFormat(new DateTime(), IntlDateFormatter::MEDIUM);  // "Jul 2, 2012"
echo $this->dateFormat(new DateTime(), IntlDateFormatter::SHORT);   // "7/2/12"
```

## NumberFormat Helper

The `NumberFormat` view helper can be used to simplify rendering of locale-specific number and
percentage strings. It acts as a wrapper for the `NumberFormatter` class within the
Internationalization extension (Intl).

### Basic Usage

```php
// Within your view

// Example of Decimal formatting:
echo $this->numberFormat(
    1234567.891234567890000,
    NumberFormatter::DECIMAL,
    NumberFormatter::TYPE_DEFAULT,
    "de_DE"
);
// This returns: "1.234.567,891"

// Example of Percent formatting:
echo $this->numberFormat(
    0.80,
    NumberFormatter::PERCENT,
    NumberFormatter::TYPE_DEFAULT,
    "en_US"
);
// This returns: "80%"

// Example of Scientific notation formatting:
echo $this->numberFormat(
    0.00123456789,
    NumberFormatter::SCIENTIFIC,
    NumberFormatter::TYPE_DEFAULT,
    "fr_FR"
);
// This returns: "1,23456789E-3"
```

### Public Methods

The `$formatStyle`, `$formatType`, and `$locale` options can be set prior to formatting and will be
applied each time the helper is used.

```php
// Within your view
$this->plugin("numberformat")
            ->setFormatStyle(NumberFormatter::PERCENT)
            ->setFormatType(NumberFormatter::TYPE_DOUBLE)
            ->setLocale("en_US");

echo $this->numberFormat(0.56);  // "56%"
echo $this->numberFormat(0.90);  // "90%"
```

## Plural Helper

Most languages have specific rules for handling plurals. For instance, in English, we say "0 cars"
and "2 cars" (plural) while we say "1 car" (singular). On the other hand, French uses the singular
form for 0 and 1 ("0 voiture" and "1 voiture") and uses the plural form otherwise ("3 voitures").

Therefore, we often need to handle those plural cases even without using translation (mono-lingual
application). The `Plural` helper was created for this. Please remember that, if you need to both
handle translation and plural, you must use the `TranslatePlural` helper for that. `Plural` does not
deal with translation.

Internally, the `Plural` helper uses the `Zend\I18n\Translator\Plural\Rule` class to handle rules.

### Setup

In Zend Framework 1, there was a similar helper. However, this helper hardcoded rules for mostly
every languages. The problem with this approach is that languages are alive and can evolve over
time. Therefore, we would need to change the rules and hence break current applications that may (or
may not) want those new rules.

That's why defining rules is now up to the developer. To help you with this process, here are some
links with up-to-date plural rules for tons of languages:

- <http://unicode.org/repos/cldr-tmp/trunk/diff/supplemental/language_plural_rules.html>
- <https://developer.mozilla.org/en-US/docs/Localization_and_Plurals>

### Basic Usage

The first thing to do is to defining rule. You may want to add this in your `Module.php` file, for
example:

```php
// Get the ViewHelperPlugin Manager from Service manager, so we can fetch the ``Plural``
// helper and add the plural rule for the application's language
$viewHelperManager = $serviceManager->get('ViewHelperManager');
$pluralHelper      = $viewHelperManager->get('Plural');

// Here is the rule for French
$pluralHelper->setPluralRule('nplurals=2; plural=(n==0 || n==1 ? 0 : 1)');
```

The string reads like that:

1.  First, we specify how many plurals forms we have. For French, only two (singular/plural).
2.  Then, we specify the rule. Here, if the count is 0 or 1, this is rule n°0 (singular) while it's
rule n°1 otherwise.

As we said earlier, English consider "1" as singular, and "0/other" as plural. Here is such a rule:

```php
// Here is the rule for English
$pluralHelper->setPluralRule('nplurals=2; plural=(n==1 ? 0 : 1)');
```

Now that we have defined the rule, we can use it in our views:

```php
<?php 
   // If the rule defined in Module.php is the English one:

   echo $this->plural(array('car', 'cars'), 0); // prints "cars"
   echo $this->plural(array('car', 'cars'), 1); // prints "car"

   // If the rule defined in Module.php is the French one:
   echo $this->plural(array('voiture', 'voitures'), 0); // prints "voiture"
   echo $this->plural(array('voiture', 'voitures'), 1); // prints "voiture"
   echo $this->plural(array('voiture', 'voitures'), 2); // prints "voitures"
?>
```

## Translate Helper

The `Translate` view helper can be used to translate content. It acts as a wrapper for the
`Zend\I18n\Translator\Translator` class.

### Setup

Before using the `Translate` view helper, you must have first created a `Translator` object and have
attached it to the view helper. If you use the `Zend\View\HelperPluginManager` to invoke the view
helper, this will be done automatically for you.

### Basic Usage

```php
// Within your view

echo $this->translate("Some translated text.");

echo $this->translate("Translated text from a custom text domain.", "customDomain");

echo sprintf($this->translate("The current time is %s."), $currentTime);

echo $this->translate("Translate in a specific locale", "default", "de_DE");
```

### Gettext

The `xgettext` utility can be used to compile \*.po files from PHP source files containing the
translate view helper.

```php
xgettext --language=php --add-location --keyword=translate my-view-file.phtml
```

See the [Gettext Wikipedia page](http://en.wikipedia.org/wiki/Gettext) for more information.

### Public Methods

Public methods for setting a `Zend\I18n\Translator\Translator` and a default text domain are
inherited from  
\[Zend\\I18n\\View\\Helper\\AbstractTranslatorHelper\](zend.i18n.view.helper.abstract-translator-helper.methods).

<!-- -->

## TranslatePlural Helper

The `TranslatePlural` view helper can be used to translate words which take into account numeric
meanings. English, for example, has a singular definition of "car", for one car. And has the plural
definition, "cars", meaning zero "cars" or more than one car. Other languages like Russian or Polish
have more plurals with different rules.

The viewhelper acts as a wrapper for the `Zend\I18n\Translator\Translator` class.

### Setup

Before using the `TranslatePlural` view helper, you must have first created a `Translator` object
and have attached it to the view helper. If you use the `Zend\View\HelperPluginManager` to invoke
the view helper, this will be done automatically for you.

### Basic Usage

```php
// Within your view
echo $this->translatePlural("car", "cars", $num);

// Use a custom domain
echo $this->translatePlural("monitor", "monitors", $num, "customDomain");

// Change locale
echo $this->translatePlural("locale", "locales", $num, "default", "de_DE");
```

### Public Methods

Public methods for setting a `Zend\I18n\Translator\Translator` and a default text domain are
inherited from  
\[Zend\\I18n\\View\\Helper\\AbstractTranslatorHelper\](zend.i18n.view.helper.abstract-translator-helper.methods).

<!-- -->

## Abstract Translator Helper

The `AbstractTranslatorHelper` view helper is used as a base abstract class for any helpers that
need to translate content. It provides an implementation for the
`Zend\I18n\Translator\TranslatorAwareInterface` which allows injecting a translator and setting a
text domain.

### Public Methods
